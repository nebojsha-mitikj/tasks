<script setup lang="ts">
import { home, login, register } from '@/routes';
import { today } from '@/routes/tasks';
import { AppPageProps } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue';

const { canRegister } = defineProps<{
    canRegister: boolean;
}>();

const page = usePage<AppPageProps>();

const isAuthenticated = computed(() => page.props.auth.user !== null);

const phrases = [
    ['Make the most of your day,', 'one task at a time.'],
    ['Build momentum,', 'one habit at a time.'],
    ['Stay on top of things,', 'one goal at a time.'],
] as const;

type AnimationPhase =
    | 'pause'
    | 'deletingLineTwo'
    | 'deletingLineOne'
    | 'typingLineOne'
    | 'typingLineTwo';

const lineOne = ref<string>(phrases[0][0]);
const lineTwo = ref<string>(phrases[0][1]);
const activeCursorLine = ref<1 | 2>(2);

const phraseIndex = ref<number>(0);
const charIndex = ref<number>(0);
const phase = ref<AnimationPhase>('pause');

const animationFrameId = ref<number | null>(null);
const lastStepTime = ref<number>(0);
const stepDelay = ref<number>(2800);

const resetTypingIndexes = (): void => {
    charIndex.value = 0;
};

const startDeleting = (): void => {
    phase.value = 'deletingLineTwo';
    activeCursorLine.value = 2;
    stepDelay.value = 0;
};

const moveToNextPhrase = (): void => {
    phraseIndex.value = (phraseIndex.value + 1) % phrases.length;
    resetTypingIndexes();
    phase.value = 'typingLineOne';
    activeCursorLine.value = 1;
    stepDelay.value = 90;
};

const handlePausePhase = (): void => {
    startDeleting();
};

const handleDeletingLineTwoPhase = (): void => {
    lineTwo.value = lineTwo.value.slice(0, -1);

    if (lineTwo.value.length === 0) {
        phase.value = 'deletingLineOne';
        activeCursorLine.value = 1;
        stepDelay.value = 80;
        return;
    }

    stepDelay.value = 24;
};

const handleDeletingLineOnePhase = (): void => {
    lineOne.value = lineOne.value.slice(0, -1);

    if (lineOne.value.length === 0) {
        moveToNextPhrase();
        return;
    }

    stepDelay.value = 24;
};

const handleTypingLineOnePhase = (): void => {
    const nextLineOne = phrases[phraseIndex.value][0];

    charIndex.value += 1;
    lineOne.value = nextLineOne.slice(0, charIndex.value);

    if (charIndex.value >= nextLineOne.length) {
        resetTypingIndexes();
        phase.value = 'typingLineTwo';
        activeCursorLine.value = 2;
        stepDelay.value = 250;
        return;
    }

    stepDelay.value = 40;
};

const handleTypingLineTwoPhase = (): void => {
    const nextLineTwo = phrases[phraseIndex.value][1];

    charIndex.value += 1;
    lineTwo.value = nextLineTwo.slice(0, charIndex.value);

    if (charIndex.value >= nextLineTwo.length) {
        resetTypingIndexes();
        phase.value = 'pause';
        stepDelay.value = 2800;
        return;
    }

    stepDelay.value = 40;
};

const animateHeadline = (): void => {
    switch (phase.value) {
        case 'pause':
            handlePausePhase();
            break;
        case 'deletingLineTwo':
            handleDeletingLineTwoPhase();
            break;
        case 'deletingLineOne':
            handleDeletingLineOnePhase();
            break;
        case 'typingLineOne':
            handleTypingLineOnePhase();
            break;
        case 'typingLineTwo':
            handleTypingLineTwoPhase();
            break;
    }
};

const animationLoop = (timestamp: number): void => {
    if (timestamp - lastStepTime.value >= stepDelay.value) {
        lastStepTime.value = timestamp;
        animateHeadline();
    }

    animationFrameId.value = requestAnimationFrame(animationLoop);
};

onMounted(() => {
    lastStepTime.value = performance.now();
    animationFrameId.value = requestAnimationFrame(animationLoop);
});

onUnmounted(() => {
    if (animationFrameId.value !== null) {
        cancelAnimationFrame(animationFrameId.value);
    }
});
</script>

<template>
    <Head />

    <div
        class="flex min-h-screen flex-col bg-white text-[#111] dark:bg-[#0a0a0a] dark:text-white"
    >
        <header
            class="sticky top-0 z-10 border-b border-black/[0.06] bg-white/80 backdrop-blur-md dark:border-white/[0.06] dark:bg-[#0a0a0a]/80"
        >
            <div
                class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4 sm:px-8"
            >
                <Link
                    :href="home()"
                    class="text-xl font-bold transition-all hover:scale-[1.02] hover:opacity-70"
                >
                    nebbo
                </Link>

                <div class="flex items-center gap-2">
                    <Link
                        v-if="isAuthenticated"
                        :href="today()"
                        class="rounded-lg bg-[#111] px-4 py-1.5 text-sm font-medium text-white transition-all hover:opacity-80 dark:bg-white dark:text-[#111]"
                    >
                        Today
                    </Link>

                    <template v-else>
                        <Link
                            :href="login()"
                            class="rounded-lg px-4 py-1.5 text-sm font-medium text-[#666] transition-all hover:text-[#111] dark:text-[#aaa] dark:hover:text-white"
                        >
                            Log in
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="register()"
                            class="rounded-lg bg-[#111] px-4 py-1.5 text-sm font-medium text-white transition-all hover:opacity-80 dark:bg-white dark:text-[#111]"
                        >
                            Register
                        </Link>
                    </template>
                </div>
            </div>
        </header>

        <main
            class="flex flex-1 flex-col items-center justify-center px-6 py-20 text-center sm:py-24"
        >
            <p
                class="mb-5 text-xs font-medium uppercase tracking-[0.24em] text-[#999]"
            >
                Personal task manager
            </p>

            <h1
                class="mb-5 min-h-[10.5rem] max-w-3xl text-4xl font-bold leading-tight tracking-tight sm:min-h-[8.5rem] sm:text-5xl"
            >
                <span>
                    {{ lineOne
                    }}<span
                    v-if="activeCursorLine === 1"
                    class="cursor-blink"
                >|</span
                >
                </span>
                <br />
                <span>
                    {{ lineTwo
                    }}<span
                    v-if="activeCursorLine === 2"
                    class="cursor-blink"
                >|</span
                >
                </span>
            </h1>

            <p
                class="mb-10 max-w-md text-base leading-relaxed text-[#666] dark:text-[#888]"
            >
                Daily focus, recurring habits, and labels — all in one minimal
                place.
            </p>

            <Link
                v-if="isAuthenticated"
                :href="today()"
                class="rounded-xl bg-[#111] px-7 py-3 text-sm font-semibold text-white transition-all hover:scale-[1.01] hover:opacity-80 active:scale-[0.99] dark:bg-white dark:text-[#111]"
            >
                Go to Today
            </Link>

            <Link
                v-else-if="canRegister"
                :href="register()"
                class="rounded-xl bg-[#111] px-7 py-3 text-sm font-semibold text-white transition-all hover:scale-[1.01] hover:opacity-80 active:scale-[0.99] dark:bg-white dark:text-[#111]"
            >
                Get started
            </Link>

            <Link
                v-else
                :href="login()"
                class="rounded-xl bg-[#111] px-7 py-3 text-sm font-semibold text-white transition-all hover:scale-[1.01] hover:opacity-80 active:scale-[0.99] dark:bg-white dark:text-[#111]"
            >
                Log in
            </Link>

            <div
                class="mt-20 grid w-full max-w-3xl grid-cols-1 gap-4 sm:grid-cols-3"
            >
                <div
                    class="rounded-2xl border border-black/[0.07] p-6 text-left transition-colors hover:border-black/[0.15] hover:bg-black/[0.02] dark:border-white/[0.07] dark:hover:border-white/[0.15] dark:hover:bg-white/[0.03]"
                >
                    <div class="mb-2 text-sm font-semibold">Daily focus</div>
                    <p
                        class="text-sm leading-relaxed text-[#666] dark:text-[#888]"
                    >
                        One place for what needs to get done today.
                    </p>
                </div>

                <div
                    class="rounded-2xl border border-black/[0.07] p-6 text-left transition-colors hover:border-black/[0.15] hover:bg-black/[0.02] dark:border-white/[0.07] dark:hover:border-white/[0.15] dark:hover:bg-white/[0.03]"
                >
                    <div class="mb-2 text-sm font-semibold">
                        Recurring tasks
                    </div>
                    <p
                        class="text-sm leading-relaxed text-[#666] dark:text-[#888]"
                    >
                        Automate repeated work with flexible schedules.
                    </p>
                </div>

                <div
                    class="rounded-2xl border border-black/[0.07] p-6 text-left transition-colors hover:border-black/[0.15] hover:bg-black/[0.02] dark:border-white/[0.07] dark:hover:border-white/[0.15] dark:hover:bg-white/[0.03]"
                >
                    <div class="mb-2 text-sm font-semibold">Labels</div>
                    <p
                        class="text-sm leading-relaxed text-[#666] dark:text-[#888]"
                    >
                        Organize and filter tasks with custom tags.
                    </p>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>
.cursor-blink {
    animation: blink 1s step-end infinite;
}

@keyframes blink {
    0%,
    100% {
        opacity: 1;
    }

    50% {
        opacity: 0;
    }
}
</style>

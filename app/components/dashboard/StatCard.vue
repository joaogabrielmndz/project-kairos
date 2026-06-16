<script setup lang="ts">
type Trend = 'up' | 'down' | 'stable' | 'goal'

const props = defineProps<{
  label: string
  value: number | string
  accent: 'green' | 'yellow' | 'red' | 'blue'
  trend: Trend
  trendLabel: string
}>()

const accentClass: Record<string, string> = {
  green: 'bg-green-500',
  yellow: 'bg-yellow-500',
  red: 'bg-red-500',
  blue: 'bg-blue-500'
}

const trendConfig: Record<Trend, { icon: string, class: string }> = {
  up: { icon: 'i-lucide-trending-up', class: 'text-green-600' },
  down: { icon: 'i-lucide-trending-down', class: 'text-red-600' },
  stable: { icon: 'i-lucide-minus', class: 'text-muted' },
  goal: { icon: 'i-lucide-circle-check', class: 'text-green-600' }
}

const trend = computed(() => trendConfig[props.trend])
</script>

<template>
  <div class="relative overflow-hidden rounded-xl border border-default bg-default shadow-sm">
    <div class="absolute inset-x-0 top-0 h-1" :class="accentClass[accent]" />
    <div class="p-5">
      <p class="text-xs font-semibold uppercase tracking-wide text-muted">
        {{ label }}
      </p>
      <p class="mt-2 text-4xl font-bold text-highlighted">
        {{ value }}
      </p>
      <div class="mt-3 flex items-center gap-1.5 text-sm font-medium" :class="trend.class">
        <UIcon :name="trend.icon" class="size-4" />
        <span>{{ trendLabel }}</span>
      </div>
    </div>
  </div>
</template>

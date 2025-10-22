<template>
  <section class="summary">
    <h2>Average Salary by Company</h2>
    <ul>
      <li v-for="item in summary" :key="item.company_name">
        {{ item.company_name }}: {{ item.avg_salary }}
      </li>
    </ul>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { getAverageSalary } from '@/api/salary'
import type { CompanySalary } from '@/api/salary'
import '@/styles/components/SalarySummary.less'

const summary = ref<CompanySalary[]>([])

async function loadSummary() {
  summary.value = (await getAverageSalary()).data
}

onMounted(() => {
  loadSummary()
})

defineExpose({
  loadSummary
})
</script>

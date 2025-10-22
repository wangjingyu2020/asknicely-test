<template>
  <main class="dashboard">
    <div class="toolbar">
      <div class="left">
        <CsvUploader @uploaded="handleUploadSuccess" />
      </div>
      <div class="right">
        <EmployeeSearch placeholder="Search..." @search="handleSearch" />
      </div>
    </div>

    <EmployeeList ref="employeeListRef" :filter="searchKeyword" />
    <SalarySummary ref="salarySummaryRef" />
  </main>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import CsvUploader from '@/components/CsvUploader.vue'
import EmployeeSearch from '@/components/EmployeeSearch.vue'
import EmployeeList from '@/components/EmployeeList.vue'
import SalarySummary from '@/components/SalarySummary.vue'
import '@/styles/views/Dashboard.less'

const employeeListRef = ref<InstanceType<typeof EmployeeList> | null>(null)
const salarySummaryRef = ref<InstanceType<typeof SalarySummary> | null>(null)

const searchKeyword = ref('')

function handleUploadSuccess() {
  employeeListRef.value?.loadEmployees()
  salarySummaryRef.value?.loadSummary()
}

function handleSearch(keyword: string) {
  searchKeyword.value = keyword
}
</script>

<template>
  <section class="list">
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Company</th>
            <th>Name</th>
            <th>Email</th>
            <th>Salary</th>
          </tr>
        </thead>
        <tbody>
          <template v-if="paginatedEmployees.length">
            <tr v-for="emp in paginatedEmployees" :key="emp.id">
              <td>{{ emp.company_name }}</td>
              <td>{{ emp.employee_name }}</td>
              <td>
                <div class="email-cell">
                  <template v-if="editingId === emp.id">
                    <input
                      v-model="editedEmail"
                      type="email"
                      @keyup.enter="saveEmail(emp)"
                      @blur="saveEmail(emp)"
                    />
                  </template>
                  <template v-else>
                    <span>{{ emp.email_address }}</span>
                    <span class="edit-icon" @click="startEdit(emp)">✏️</span>
                  </template>
                </div>
              </td>
              <td>{{ emp.salary }}</td>
            </tr>
          </template>
          <template v-else>
            <tr>
              <td colspan="4" class="no-data">No data available</td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <div class="pagination">
      <button @click="prevPage" :disabled="page === 1">←</button>
      <span>{{ page }} / {{ totalPages }}</span>
      <button @click="nextPage" :disabled="page === totalPages">→</button>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, defineProps, defineExpose } from 'vue'
import { getEmployees, updateEmail } from '@/api/employee'
import type { Employee } from '@/types/employee'
import '@/styles/components/EmployeeList.less'

const props = defineProps<{ filter?: string }>()

const employees = ref<Employee[]>([])
const page = ref(1)
const pageSize = 10

const editingId = ref<number | null>(null)
const editedEmail = ref('')

const filteredEmployees = computed(() => {
  if (!props.filter) return employees.value
  const keyword = props.filter.toLowerCase()
  return employees.value.filter(e =>
    e.employee_name.toLowerCase().includes(keyword) ||
    e.company_name.toLowerCase().includes(keyword) ||
    e.email_address.toLowerCase().includes(keyword) ||
    String(e.salary).includes(keyword)
  )
})

const paginatedEmployees = computed(() => {
  const start = (page.value - 1) * pageSize
  return filteredEmployees.value.slice(start, start + pageSize)
})

const totalPages = computed(() =>
  Math.max(1, Math.ceil(filteredEmployees.value.length / pageSize))
)

function prevPage() {
  if (page.value > 1) page.value--
}

function nextPage() {
  if (page.value < totalPages.value) page.value++
}

async function loadEmployees() {
  const response = await getEmployees()
  employees.value = response.data
  page.value = 1
}

function startEdit(emp: Employee) {
  editingId.value = emp.id
  editedEmail.value = emp.email_address
}

function cancelEdit() {
  editingId.value = null
  editedEmail.value = ''
}

async function saveEmail(emp: Employee) {
  const trimmed = editedEmail.value.trim()
  if (!trimmed || trimmed === emp.email_address) {
    cancelEdit()
    return
  }

  try {
    await updateEmail(emp.employee_name, trimmed)
    emp.email_address = trimmed
    alert('Email updated successfully')
  } catch (err) {
    alert('Update failed, please try again')
  } finally {
    cancelEdit()
  }
}

onMounted(loadEmployees)
defineExpose({ loadEmployees })
</script>

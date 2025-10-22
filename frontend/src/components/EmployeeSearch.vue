<template>
  <section class="search">
    <div class="search-wrapper">
      <input
        v-model="keyword"
        type="text"
        :placeholder="placeholder"
        @input="onSearch"
      />
      <span class="search-icon">
        🔍
      </span>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, defineEmits, defineProps } from 'vue'
import '@/styles/components/EmployeeSearch.less'

defineProps<{ placeholder?: string }>()
const emit = defineEmits(['search'])

const keyword = ref('')
function onSearch() {
  emit('search', keyword.value.trim())
}
</script>

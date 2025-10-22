<template>
  <section class="uploader">
    <label class="button choose-button">
      Choose File
      <input type="file" accept=".csv" @change="handleFile" hidden />
    </label>

    <span class="filename" v-if="file">{{ file.name }}</span>

    <button class="button upload-button" @click="upload" :disabled="!file">Upload</button>
  </section>
</template>

<script setup lang="ts">
import { ref, defineEmits } from 'vue'
import { uploadCsv } from '@/api/employee'
import '@/styles/components/CsvUploader.less'

const emit = defineEmits(['uploaded'])
const file = ref<File | null>(null)
const fileInputRef = ref<HTMLInputElement | null>(null)

function handleFile(e: Event) {
  const target = e.target as HTMLInputElement
  if (target.files?.[0]) {
    file.value = target.files[0]
  }
}

async function upload() {
  if (!file.value) return
  const formData = new FormData()
  formData.append('csv', file.value)
  await uploadCsv(formData)
  alert('Upload successful')
  emit('uploaded')

  file.value = null
  if (fileInputRef.value) {
    fileInputRef.value.value = ''
  }
}
</script>

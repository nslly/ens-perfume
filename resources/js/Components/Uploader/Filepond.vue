<template>
  <div>
    <file-pond
        name="images[]" 
        ref="pond"
        label-idle="Drag & Drop your images or <span class='filepond--label-action'>Browse</span>"
        allow-multiple="true"
        accepted-file-types="image/jpeg, image/png, image/webp"
        max-files="10"
        :server="serverOptions"
        :files="files"
        @init="handleInit"
        @processfile="handleProcessFile"
        @removefile="handleRemoveFile"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import vueFilePond from 'vue-filepond'
import 'filepond/dist/filepond.min.css'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
)

const props = defineProps({
  modelValue: Array,
  existingFiles: Array
})

const emit = defineEmits(['update:modelValue', 'uploaded', 'removed'])

const pond = ref(null)
const files = ref([])

const serverOptions = {
  process: {
    url: '/admin/upload',
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'

    },
    ondata: (formData) => {
        for (const [key, value] of formData.entries()) {
            console.log('FormData:', key, value);
        }
      return formData
    }
  },
  revert: {
    url: '/admin/upload/delete',
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    }
  },
  load: {
    url: '/admin/upload/load',
    method: 'GET'
  }
}

const handleInit = () => {
  console.log('FilePond initialized')
}

const handleProcessFile = (error, file) => {
  if (error) {
    console.error('Error uploading file:', error)
    return
  }
  emit('uploaded', file.serverId)
  updateModelValue()
}

const handleRemoveFile = (error, file) => {
  if (error) {
    console.error('Error removing file:', error)
    return
  }
  emit('removed', file.serverId)
  updateModelValue()
}

const updateModelValue = () => {
  if (pond.value) {
    const fileItems = pond.value.getFiles()
    emit('update:modelValue', fileItems.map(file => file.serverId))
  }
}

onMounted(() => {
  if (props.existingFiles) {
    files.value = props.existingFiles.map(file => ({
      source: file.id,
      options: {
        type: 'local',
        file: {
          name: file.name,
          size: file.size,
          type: file.type
        },
        metadata: {
          poster: file.url
        }
      }
    }))
  }
})
</script>
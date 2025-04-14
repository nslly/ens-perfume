<template>
  <div>
    <file-pond
        name="images" 
        ref="pond"
        label-idle="Drag & Drop your images or <span class='filepond--label-action'>Browse</span> ( 5 Maximum Images )"
        allow-multiple="true"
        accepted-file-types="image/jpeg, image/png, image/webp"
        max-files="5"    
        max-file-size="2MB"
        :server="serverOptions"
        :files="files"
        @processfile="handleProcessFile"
        @removefile="handleRemoveFile"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, watch, defineProps, defineEmits  } from 'vue';
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'


const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginFileValidateSize
)

const props = defineProps({
  modelValue: Array,
  existingFiles: {
    type: Array,
    default: () => []
  }
})


// const emit = defineEmits(['update:modelValue', 'uploaded', 'removed', 'update:files'])

const emit = defineEmits(['update:modelValue', 'update:files'])


const pond = ref(null)
const files = ref([])
const isInitializing = ref(true)


// Convert existing files to FilePond format
const formatExistingFiles = (files) => {
  return files.map(file => ({
    source: file.url || `/storage/${file.path || file}`,
    options: {
      type: 'local',
      metadata: {
        poster: file.url || `/storage/${file.path || file}`
      }
    }
  }))
}


// Initialize with existing files
onMounted(() => {
  files.value = formatFiles(props.existingFiles)
  isInitializing.value = false
})
// Watch for external changes to existingFiles
watch(() => props.existingFiles, (newFiles) => {
  if (isInitializing.value) return
  files.value = formatFiles(newFiles)
}, { deep: true })


const formatFiles = (files) => {
  return files.map(file => ({
    source: file.url || file,
    options: {
      type: 'local',
      metadata: {
        poster: file.url || file
      }
    }
  }))
}

watch(files, (newFiles) => {
  const simplifiedFiles = newFiles.map(file => {
    if (!file) return null;
    
    return file.file 
      ? file.file 
      : (file.source ? file.source.replace('/storage/', '') : null);
  }).filter(Boolean);
  
  emit('update:modelValue', simplifiedFiles);
  emit('update:files', newFiles);
}, { deep: true });

const serverOptions = {
  process: {
    url: '/admin/upload',
    method: 'POST',
    withCredentials: false,
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'

    },
    ondata: (formData) => {
      return formData;

    },
    onload: (res) => {
      const data = JSON.parse(res)
      return data.id
    },
    onerror: (res) => {
      const err = JSON.parse(res)
      return err.message || 'Upload failed'
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


const handleProcessFile = (error, file) => {

  if (error) {
    console.error('Error uploading file:', error)
    return
  }

  const serverResponse = file.serverId
  updateModelValue()
}

const handleRemoveFile = (error, file) => {
  if (error) {
    console.error('Error removing file:', error)
    return
  }
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
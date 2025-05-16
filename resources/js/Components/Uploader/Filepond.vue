<template>
  <div class="filepond-container">
    <file-pond
      name="image"
      ref="pond"
      label-idle="Drag & Drop your image or <span class='filepond--label-action'>Browse</span>"
      allow-multiple="false"
      accepted-file-types="image/jpeg, image/png, image/webp"
      max-files="1"
      max-file-size="2MB"
      :files="files"
      :server="serverOptions"
      @processfile="handleProcessFile"
      @removefile="handleRemoveFile"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, watch, defineProps, defineEmits } from 'vue';
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginFileValidateSize
);

// Props
const props = defineProps({
  modelValue: String,
  existingFile: String
});
const emit = defineEmits(['update:modelValue']);

// Refs
const pond = ref(null);
const files = ref([]);
const isInitializing = ref(true);

// Format existing file
const formatExistingFiles = (files) => {
  if (!files || typeof files !== 'string') return [];

  return [{
    source: files,
    options: {
      type: 'local',
      metadata: {
        poster: `/storage/${files}`
      }
    }
  }];
};

// On mount: load existing file
onMounted(() => {
  files.value = formatExistingFiles(props.existingFile);
  isInitializing.value = false;
});

// Watch for changes to existingFile
watch(() => props.existingFile, (newVal) => {
  if (isInitializing.value) return;
  files.value = formatExistingFiles(newVal);
});

// Watch for file changes and emit new value
watch(files, (newFiles) => {
  const uploadedFiles = newFiles
    .map(f => f.serverId || (f.source && typeof f.source === 'string' ? f.source : null))
    .filter(Boolean);

  emit('update:modelValue', uploadedFiles.length ? uploadedFiles[0] : '');
}, { deep: true });

// Server config
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
  load: (source, load, error, progress, abort, headers) => {
    const request = new XMLHttpRequest();
    request.open('GET', `/admin/upload/load?id=${source}`);
    request.responseType = 'blob';

    request.onload = () => {
      if (request.status >= 200 && request.status < 300) {
        load(request.response);
      } else {
        error('Failed to load file');
      }
    };

    request.onerror = () => error('Load error');
    request.send();

    return {
      abort: () => {
        request.abort();
        abort();
      }
    };
  }


};

// Handlers
const handleProcessFile = () => updateModelValue();
const handleRemoveFile = () => updateModelValue();

const updateModelValue = () => {
  const fileItems = pond.value?.getFiles() || [];
  const fileIds = fileItems.map(file => file.serverId || file.source);
  emit('update:modelValue', fileIds.length ? fileIds[0] : '');
};
</script>

<template>
  <span>
    <span id="codex-editor" class="relative">
      <EditorHeader :editor="editor" />

      <editor-content v-model="value" :editor="editor" />
    </span>
  </span>
</template>

<script setup>
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import TextAlign from '@tiptap/extension-text-align'
import TextUnderline from '@tiptap/extension-underline'
import { computed, onDeactivated, onMounted, ref } from 'vue'
import InputExtension from './Utils/CustomTiptapExtensions/InputExtension'
import ShortcodeExtension from './Utils/CustomTiptapExtensions/ShortcodeExtension'
import EditorHeader from './EditorHeader.vue'
const editor = ref(null)

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  }
})

const emits = defineEmits(['update:modelValue'])

onMounted(() => {
  editor.value = new Editor({
    content: props.modelValue,
    extensions: [
      StarterKit,
      TextUnderline,
      TextAlign.configure({
        types: ['heading', 'paragraph']
      }),
      InputExtension,
      ShortcodeExtension,
    ],
    onUpdate: () => {
      emits('update:modelValue', editor.value.getHTML())
    }
  })
})

onDeactivated(() => {
  editor.value.destroy()
})

const value = computed({
  get () {
    return props.modelValue
  },
  set (value) {
    emit('update:modelValue', value)
  }
})
</script>

<style lang="scss">
#codex-editor {
  width: 100%;
  margin: auto;
}

.ProseMirror {
  min-height: 40vh;
  padding: 10px;
  box-shadow: 0 0 5px hsl(0deg 0% 0% / 20%);
  border: 1px solid #ccced1;
  background-color: #EFF0F7 !important;
  border-radius: 8px;
  border: none;
  padding: 18px;
  font-size: 16px;
}

.ProseMirror:focus {
  outline: none;
}
.ProseMirror p {
  line-height: 23px !important;
  font-size: 16px !important;
  margin: 0px !important;
}

.ProseMirror ul, .ProseMirror ol {
  @apply list-outside ml-1 pl-7;
}
.ProseMirror ul {
  @apply list-disc;
}

.ProseMirror ol {
  @apply list-decimal;
}

.drop-zone {
  width: 50%;
  margin: 50px auto;
  background-color: #ecf0f1;
  padding: 10px;
  min-height: 10px;
}
.drag-el {
  background-color: #3498db;
  color: white;
  padding: 5px;
  margin-bottom: 10px;
}
.drag-el:nth-last-of-type(1) {
  margin-bottom: 0px;
}

.toolbar-container {
  box-shadow: 0 0 5px hsl(0deg 0% 0% / 20%);
  border: 1px solid #ccced1;
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  padding: 0.5rem 1rem;
}

.toolbar-container button {
  border: none;
  border-radius: 6px;
  margin: 0 0.5rem;
  padding: 0.3rem 0.5rem;
  cursor: pointer;
  background-color: transparent;
}

.toolbar-container button:hover {
  background-color: #ecf0f1;
}

.toolbar-container button.active {
  background-color: #f0f7ff;
  color: black;
}

.toolbar-container button img {
  height: 20px;
  width: 20px;
  object-position: center;
  vertical-align: middle;
}

.toolbar-container .toolbar__wrap-section {
  /* margin: 0 5px; */
  border-right: 1px solid #ccced1;
  /* border-left: 1px solid #ccced1; */
  /* padding: 0 1rem; */
}
.toolbar-container .toolbar__wrap-section select {
  width: 150px;
  height: 100%;
  border: none;
  background: transparent;
}
.toolbar-container .toolbar__wrap-section select:hover,
.toolbar-container .toolbar__wrap-section select:focus {
  background-color: #ecf0f1;
  border: none;
  outline: none;
}
</style>

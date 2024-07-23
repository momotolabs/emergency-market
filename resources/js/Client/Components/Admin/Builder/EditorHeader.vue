<script setup>
import { ref } from 'vue';
import {
  AlignLeftOutlined, AlignCenterOutlined,
  AlignRightOutlined,BoldOutlined,
  ItalicOutlined, UnderlineOutlined,
  StrikethroughOutlined, UnorderedListOutlined,
  OrderedListOutlined, LineOutlined,
  ExpandOutlined, RollbackOutlined, ToolOutlined
} from '@ant-design/icons-vue'

defineProps({
  editor: {
    type: [Object, null],
    required: true
  }
})
const headings = ref([
  { value: 0, label: 'Paragraph' },
  { value: 1, label: 'Heading 1' },
  { value: 2, label: 'Heading 2' },
  { value: 3, label: 'Heading 3' },
  { value: 4, label: 'Heading 4' }
])

const setSelectedHeading = (editor, event) => {
  if (event.target.value == 0) {
    editor.chain().focus().setParagraph().run()
  } else {
    editor
      .chain()
      .focus()
      .toggleHeading({ level: Number(event.target.value) })
      .run()
  }
}
</script>
<template>
  <div v-if="editor">
    <div class="toolbar-container">
      <div class="toolbar__wrap-section">
        <select @change="setSelectedHeading(editor, $event)">
          <option
            v-for="heading in headings"
            :key="heading.value"
            :value="heading.value"
          >
            {{ heading.label }}
          </option>
        </select>
      </div>
      <div class="toolbar__wrap-section">
        <button type="button"
          :class="{ active: editor.isActive({ textAlign: 'left' }) }"
          title="Align Left"
          @click="editor.chain().focus().setTextAlign('left').run()"
        >
          <AlignLeftOutlined />
        </button>
        <button type="button"
          :class="{ active: editor.isActive({ textAlign: 'center' }) }"
          title="Align Center"
          @click="editor.chain().focus().setTextAlign('center').run()"
        >
          <AlignCenterOutlined />
        </button>
        <button type="button"
          :class="{ active: editor.isActive({ textAlign: 'right' }) }"
          title="Align Right"
          @click="editor.chain().focus().setTextAlign('right').run()"
        >
          <AlignRightOutlined />
        </button>
        <button type="button"
          :class="{ active: editor.isActive({ textAlign: 'justify' }) }"
          title="Align justify"
          @click="editor.chain().focus().setTextAlign('justify').run()"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><line x1="21" y1="10" x2="3" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="21" y1="18" x2="3" y2="18"></line></svg>
        </button>
      </div>

      <div class="toolbar__wrap-section">
        <button type="button"
          :class="{ active: editor.isActive('bold') }"
          title="Bold"
          @click="editor.chain().focus().toggleBold().run()"
        >
          <BoldOutlined />
        </button>
        <button type="button"
          :class="{ active: editor.isActive('italic') }"
          title="Italic"
          @click="editor.chain().focus().toggleItalic().run()"
        >
          <ItalicOutlined />
        </button>
        <button type="button"
          :class="{ active: editor.isActive('underline') }"
          title="Underline"
          @click="editor.chain().focus().toggleUnderline().run()"
        >
          <UnderlineOutlined />
        </button>
        <button type="button"
          :class="{ active: editor.isActive('strike') }"
          title="Strikethtrough"
          @click="editor.chain().focus().toggleStrike().run()"
        >
          <StrikethroughOutlined />
        </button>
      </div>

      <div class="toolbar__wrap-section">
        <button type="button"
          :class="{ active: editor.isActive('bulletList') }"
          title="Unordered List"
          @click="editor.chain().focus().toggleBulletList().run()"
        >
          <UnorderedListOutlined />
        </button>
        <button type="button"
          :class="{ active: editor.isActive('orderedList') }"
          title="Ordered List"
          @click="editor.chain().focus().toggleOrderedList().run()"
        >
          <OrderedListOutlined />
        </button>

        <button type="button" title="Remove" @click="editor.chain().focus().setHorizontalRule().run()">
          <LineOutlined />
        </button>
      </div>
      <div class="toolbar__wrap-section">
        <button type="button"
          :class="{ active: editor.isActive('input') }"
          title="Initials"
          @click="editor.chain().focus().addInput().run()"
        >
          <ExpandOutlined />
        </button>
      </div>
      <div class="toolbar__wrap-section">
        <button type="button" title="Undo" @click="editor.chain().focus().undo().run()">
          <RollbackOutlined />
        </button>
        <button type="button" title="Reundo" @click="editor.chain().focus().redo().run()">
          <RollbackOutlined :rotate="180" />
        </button>
      </div>
    </div>

    <div
      class="
        group absolute bottom-4 right-4 bg-white w-11 h-11 hover:w-max hover:h-max rounded-md z-50 shadow-lg
        transition-all duration-500 hover:p-4
      "
      >
      <div class="text-center flex items-center justify-center h-full group-hover:hidden cursor-pointer">
        <p class="m-0">{...}</p>
      </div>
      <div class="opacity-0 group-hover:opacity-100">
        <div class="grid grid-cols-2 text-white gap-3 transition-all ease-in duration-500 scale-0 group-hover:scale-100">
          <button class="bg-lightgreen py-[2px] px-2 rounded-md" type="button" title="Shortcode" @click="editor.chain().focus().addShortcode('first_name').run()">
            First Name
          </button>
          <button class="bg-lightgreen py-[2px] px-2 rounded-md" type="button" title="Shortcode" @click="editor.chain().focus().addShortcode('last_name').run()">
            Last name
          </button>
          <button class="bg-lightgreen py-[2px] px-2 rounded-md" type="button" title="Shortcode" @click="editor.chain().focus().addShortcode('address').run()">
            Address
          </button>
          <button class="bg-lightgreen py-[2px] px-2 rounded-md" type="button" title="Shortcode" @click="editor.chain().focus().addShortcode('phone_number').run()">
            Phone number
          </button>
          <button class="bg-lightgreen py-[2px] px-2 rounded-md" type="button" title="Shortcode" @click="editor.chain().focus().addShortcode('insurance_company').run()">
            Insurance company
          </button>
          <button class="bg-lightgreen py-[2px] px-2 rounded-md" type="button" title="Shortcode" @click="editor.chain().focus().addShortcode('claim_number').run()">
            Claim number
          </button>
          <button class="bg-lightgreen py-[2px] px-2 rounded-md" type="button" title="Shortcode" @click="editor.chain().focus().addShortcode('email').run()">
            Email
          </button>
          <button class="bg-lightgreen py-[2px] px-2 rounded-md" type="button" title="Shortcode" @click="editor.chain().focus().addShortcode('date').run()">
            Date Signed
          </button>
          <button type="button"
            class="bg-lightgreen py-[2px] px-2 rounded-md"
            :class="{ active: editor.isActive('input') }"
            title="Initials"
            @click="editor.chain().focus().addInput().run()"
          >
            Initials
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

import { Extension } from '@tiptap/core'

const ShortcodeExtension = Extension.create({
  name: 'shortcode',

  addOptions () {
    return {

    }
  },

  parseHTML () {
    return [
      {
        tag: 'span'
      }
    ]
  },

  addAttributes () {
    return {
      type: {
        default: 'text'

      },
      value: {
        default: ''
      }
    }
  },

  addCommands () {
    return {
      addShortcode: (option) => ({ commands }) => {
        return commands.insertContent(`{${option}}`)
      }
    }
  }
})

export default ShortcodeExtension
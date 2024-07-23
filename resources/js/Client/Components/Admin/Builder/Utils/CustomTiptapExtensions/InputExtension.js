import { Extension } from '@tiptap/core'

const InputExtension = Extension.create({
  name: 'input',

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
      addInput: () => ({ commands }) => {
        return commands.insertContent('[initials]')
      }
    }
  }
})

export default InputExtension

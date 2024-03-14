import * as yup from 'yup'
import {createI18n} from 'vue-i18n'

export const localYup = () => {
    const locale = {
        mixed: {
            required: i18n.global.t('required'),
        },
        string: {
            default: i18n.global.t('string.default'),
            email: i18n.global.t('string.email'),
        },
        number: {
            integer: i18n.global.t('number.integer'),
            required: i18n.global.t('number.required'),
            positive: i18n.global.t('number.positive'),
        },

    }
    yup.setLocale(locale)
}

const i18n = createI18n({
  locale: 'es',
  messages: {
    es: {
      required: 'El campo es requerido',
      string: {
        default: 'El campo debe ser texto',
        email: 'El campo debe ser un correo electrónico',
        max: 'El campo excede el número de caracteres permitidos'
      },
      number: {
        integer: 'El campo debe ser un entero',
        required: 'El campo es requerido',
        positive: 'El campo debe ser mayor a 0',
      }
    },
    en: {
      required: 'The field is required',
      string: {
        default: 'The field must be text',
        email: 'The field must be an email',
        max: 'The field exceeds the number of characters allowed'
      },
      number: {
        integer: 'The field must be an integer',
        required: 'The field is required',
        positive: 'The field must be greater than 0',
      }
    }
  }
})


import * as Yup from 'yup'
import printValue from 'yup/es/util/printValue'

Yup.setLocale({
    mixed: {
        default: '${path} tidak valid',
        required: '${path} adalah bidang yang wajib diisi',
        defined: '${path} harus didefinisikan',
        notNull: '${path} tidak boleh nol',
        oneOf: '${path} harus salah satu dari nilai berikut: ${values}',
        notOneOf: '${path} tidak boleh salah satu dari nilai berikut: ${values}',
        notType: ({ path, type, value, originalValue }) => {
            const castMsg =
                originalValue != null && originalValue !== value
                ? ` (dilemparkan dari nilai \`${printValue(originalValue, true)}\`).`
                : '.';
        
            return type !== 'mixed'
                ? `${path} harus menjadi \`${type}\` type, ` +
                    `tapi nilai akhirnya adalah: \`${printValue(value, true)}\`` +
                    castMsg
                : `${path} harus cocok dengan tipe yang dikonfigurasi. ` +
                    `Nilai yang divalidasi adalah: \`${printValue(value, true)}\`` +
                    castMsg;
        },
    },
    string: {
        length: '${path} harus tepat ${length} karakter',
        min: '${path} minimal harus ${min} karakter',
        max: '${path} maksimal ${max} karakter',
        matches: '${path} harus cocok dengan berikut ini: "${regex}"',
        email: '${path} harus email yang valid',
        url: '${path} harus berupa URL yang valid',
        uuid: '${path} harus berupa UUID yang valid',
        trim: '${path} harus berupa string yang dipangkas',
        lowercase: '${path} harus berupa string huruf kecil',
        uppercase: '${path} harus berupa string huruf besar',
    },
    number: {
        min: '${path} harus lebih besar dari atau sama dengan ${min}',
        max: '${path} harus kurang dari atau sama dengan ${max}',
        lessThan: '${path} harus lebih kecil dari ${less}',
        moreThan: '${path} harus lebih besar dari ${more}',
        positive: '${path} harus bilangan positif',
        negative: '${path} harus berupa angka negatif',
        integer: '${path} harus bilangan bulat',
    },
    date: {
        min: '${path} harus lebih dari ${min}',
        max: '${path} harus lebih awal dari ${max}',
    }
})

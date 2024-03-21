import { TYPE } from 'vue-toastification'
import { toast } from '@/Helpers/Toast'
import { MAX_IMAGE_SIZE } from '@core/config'
import { getI18n } from '@/plugins/i18n'

const { t } = getI18n()

export type FileResult = ArrayBuffer | string | null

export interface GetImageResponse {
  file: File
  imageData: FileResult
}

export async function getImage(event: Event): Promise<GetImageResponse> {
  const file = (event.target as HTMLInputElement).files?.[0]

  if (file) {
    if (file.size / 1024 > MAX_IMAGE_SIZE) {
      toast(t('errors.upload.file_size_too_big'), TYPE.ERROR)

      return Promise.reject(Error('FILE_SIZE_TOO_BIG'))
    }

    if (!file.type.startsWith('image/')) {
      toast(t('errors.upload.file_must_be_image'), TYPE.ERROR)

      return Promise.reject(Error('FILE_MUST_BE_IMAGE'))
    }

    const reader: FileReader = new FileReader()

    reader.readAsDataURL(file)

    return await new Promise(
      resolve =>
        (reader.onload = (e: ProgressEvent<FileReader>) =>
          resolve({
            file,
            imageData: e.target?.result ?? null,
          })),
    )
  }

  return Promise.reject(Error('FILE_NOT_FOUND'))
}

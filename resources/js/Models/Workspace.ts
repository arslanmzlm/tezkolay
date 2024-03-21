import type { DateTime } from 'luxon'
import Model from '@/Models/Model'
import Group from '@/Models/Group'
import type { FileResult, GetImageResponse } from '@/Helpers/Upload'
import { getImage } from '@/Helpers/Upload'
import { dateToFullString } from '@/Helpers/DateHelper'
import { APP_URL } from '@core/config'
import { getI18n } from '@/plugins/i18n'

const { t } = getI18n().global

class Workspace extends Model {
  public readonly user_id: number | null = null
  public name: string | null = null
  public logo: File | string | null = null
  public groups: Group[] = []

  constructor(data: Record<string, any> | null = null) {
    super(data)

    if (data !== null) {
      this.user_id = data.user_id ?? null
      this.name = data.name ?? null
      this.logo = data.logo ?? null
      this.groups = []

      if (data.groups && data.groups.length) {
        data.groups.forEach((item: Record<string, any>) => {
          this.addGroup(item)
        })
      }
    }
  }

  get data(): object {
    return {
      name: this.name,
      logo: this.logo,
      groups: this.groups,
    }
  }

  get logoSrc(): string {
    return this.logo ? `${APP_URL}/images/workspaces/logos/${this.logo}` : ''
  }

  get createdAtLocal(): string {
    return dateToFullString(<DateTime> this.created_at)
  }

  addGroup(data: Record<string, any> | null = null): Group {
    if (!data) {
      data = {
        name: `${t('titles.group')} ${this.groups.length + 1}`,
        size: 0,
      }
    }

    const group: Group = new Group(data)

    this.groups.push(group)

    return group
  }

  removeGroup(index: number): void {
    this.groups.splice(index, 1)
  }

  async setLogoFile(event: Event): Promise<FileResult> {
    const response: GetImageResponse | void = await getImage(event)

    if (response !== null && typeof response === 'object') {
      this.logo = response.file

      return response.imageData
    }

    return null
  }
}

export default Workspace

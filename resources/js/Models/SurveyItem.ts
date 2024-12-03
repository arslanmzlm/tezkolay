import Model from '@/Models/Model'
import {getI18n} from "@/plugins/i18n";
import {SURVEY_ITEM_STATE} from "@core/enums";

const { t } = getI18n().global

class SurveyItem extends Model {
  public survey_id: number | null = null
  public patient_id: number | null = null
  public state: SURVEY_ITEM_STATE | null = null
  public token: string | null = null
  public message_id: number | null = null
  public sent_at: string | null = null
  public completed_at: string | null = null
  public filled_by_user: boolean = false

  constructor(data: Record<string, any> | null = null) {
    super(data)

    if (data !== null) {
      this.survey_id = typeof data.survey_id !== "undefined" ? Number.parseInt(data.survey_id) : null
      this.patient_id = typeof data.patient_id !== "undefined" ? Number.parseInt(data.patient_id) : null
      this.state = data.state
      this.token = data.token ?? null
      this.message_id = typeof data.message_id !== "undefined" ? Number.parseInt(data.message_id) : null
      this.sent_at = data.sent_at ?? null
      this.completed_at = data.completed_at ?? null
      this.filled_by_user = Boolean(data.filled_by_user ?? false)
    }
  }

  get stateLabel(): string {
    return t(`models.survey_item.states.${this.state}`) ?? ''
  }

  get stateColor(): string {
    switch (this.state) {
      case SURVEY_ITEM_STATE.CREATED:
        return 'warning'
      case SURVEY_ITEM_STATE.SENT:
        return 'info'
      case SURVEY_ITEM_STATE.COMPLETED:
        return 'success'
      default:
        return 'primary'
    }
  }
}

export default SurveyItem

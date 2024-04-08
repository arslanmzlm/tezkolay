import Model from '@/Models/Model'

class SurveyItem extends Model {
  public survey_id: number | null = null
  public patient_id: number | null = null
  public token: string | null = null
  public sent_at: string | null = null
  public completed_at: string | null = null
  public filled_by_user: boolean = false

  constructor(data: Record<string, any> | null = null) {
    super(data)

    if (data !== null) {
      this.survey_id = typeof data.survey_id !== "undefined" ? Number.parseInt(data.survey_id) : null
      this.patient_id = typeof data.patient_id !== "undefined" ? Number.parseInt(data.patient_id) : null
      this.token = data.token ?? null
      this.sent_at = data.sent_at ?? null
      this.completed_at = data.completed_at ?? null
      this.filled_by_user = Boolean(data.filled_by_user ?? false)
    }
  }
}

export default SurveyItem

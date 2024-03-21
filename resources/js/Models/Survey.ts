import { DateTime } from 'luxon'
import Model from '@/Models/Model'
import QuestionHelper from '@/Helpers/QuestionHelper'

class Survey extends Model {
  public group_id: number | null = null
  public template_id: number | null = null
  public name: string | null = null
  public survey_at: DateTime | string | null = null
  public state: string | null = null
  public questions: QuestionHelper = new QuestionHelper()

  constructor(data: Record<string, any> | null = null) {
    super(data)

    if (data !== null) {
      this.group_id = data.group_id ?? null
      this.template_id = data.template_id ?? null
      this.name = data.name ?? null
      this.survey_at = data.survey_at ?? null
      this.state = data.state ?? null

      if (data.questions && data.questions.length) {
        this.questions.addFromFetch(data.questions)

        this.questions.reOrder()
      }
    }
  }

  getData(): Record<string, any> {
    return {
      template_id: this.template_id,
      name: this.name,
      survey_at: this.survey_at,
    }
  }

  setSurveyAt(val: string | DateTime | null) {
    if (val instanceof DateTime)
      this.survey_at = val
    else if (typeof val === 'string')
      this.survey_at = DateTime.fromISO(val)
    else
      this.survey_at = null
  }

  get isEditable(): boolean {
    return this.state === 'created' || this.state === null
  }

  get isDeletable(): boolean {
    return this.state === 'created' || this.state === null
  }
}

export default Survey

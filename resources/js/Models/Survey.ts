import Model from '@/Models/Model'
import QuestionHelper from '@/Helpers/QuestionHelper'
import { getI18n } from '@/plugins/i18n'
import { SURVEY_STATE } from '@core/enums'

const { t } = getI18n().global

class Survey extends Model {
  public group_id: number | null = null
  public template_id: number | null = null
  public name: string | null = null
  public survey_at: string | null = null
  public state: SURVEY_STATE | null = null
  public questions: QuestionHelper = new QuestionHelper()
  public readonly group_name: string | null = null
  public readonly group_size: number | null = null
  public readonly completed_count: number | null = null
  public readonly completed_percent: number | null = null

  constructor(data: Record<string, any> | null = null) {
    super(data)

    if (data !== null) {
      this.group_id = typeof data.group_id !== 'undefined' ? Number.parseInt(data.group_id) : null
      this.template_id = typeof data.template_id !== 'undefined' ? Number.parseInt(data.template_id) : null
      this.name = data.name ?? null
      this.survey_at = data.survey_at ?? null
      this.state = data.state ?? null
      this.group_name = data.group_name ?? null
      this.group_size = typeof data.group_size !== 'undefined' ? Number.parseInt(data.group_size) : null
      this.completed_count = typeof data.completed_count !== 'undefined' ? Number.parseInt(data.completed_count) : null
      this.completed_percent = typeof data.completed_percent !== 'undefined' ? Number.parseFloat(data.completed_percent) : null

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

  getAnswerData(): Record<string, any> {
    const answers: Array<object> = []

    this.questions.items.forEach(question => {
      answers.push({
        question_id: question.id,
        answer: question.value,
      })
    })

    return { answers }
  }

  get isEditable(): boolean {
    return this.state === SURVEY_STATE.CREATED || this.state === null
  }

  get isDeletable(): boolean {
    return this.state === SURVEY_STATE.CREATED || this.state === null
  }

  get isStartAble(): boolean {
    return this.state === SURVEY_STATE.CREATED || this.state === null
  }

  get surveyDateFormatted(): string {
    if (this.survey_at)
      return formatDate(this.survey_at, { day: 'numeric', month: 'long', year: 'numeric' })

    return ''
  }

  get stateLabel(): string {
    return t(`models.survey.states.${this.state}`) ?? ''
  }

  get stateColor(): string {
    switch (this.state) {
      case SURVEY_STATE.CREATED:
        return 'warning'
      case SURVEY_STATE.INITIALIZED:
        return 'info'
      case SURVEY_STATE.SENT:
        return 'info'
      case SURVEY_STATE.COMPLETED:
        return 'success'
      default:
        return 'primary'
    }
  }
}

export default Survey

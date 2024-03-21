import Model from '@/Models/Model'
import QuestionHelper from '@/Helpers/QuestionHelper'

class Template extends Model {
  public name: string | null = null
  public description: string | null = null
  public questions: QuestionHelper = new QuestionHelper()
  public is_private: boolean | null = null
  public readonly created_by: number | null = null

  constructor(data: Record<string, any> | null = null) {
    super(data)

    if (data !== null) {
      this.name = data.name ?? null
      this.description = data.description ?? null
      this.created_by = data.created_by ?? null
      this.is_private = Boolean(data.is_private) ?? null

      if (data.questions && data.questions.length) {
        this.questions.addFromFetch(data.questions)

        this.questions.reOrder()
      }
    }
  }

  getData(): Record<string, any> {
    return {
      name: this.name,
      description: this.description,
      is_private: this.is_private,
      questions: this.questions.all(),
    }
  }
}

export default Template

import { cloneDeep, isArray } from 'lodash'
import { isNumericString } from '@sindresorhus/is'
import Model from '@/Models/Model'
import type Type from '@/Models/Type'
import { APP_URL } from '@core/config'

class Question extends Model {
  public readonly template_id: number | null = null
  public readonly survey_id: number | null = null
  public type_id: number | null = null
  public category: string | null = null
  public component: string | null = null
  public label: string | null = null
  public description: string | null = null
  public required: boolean | null = false
  public order: number | null = null
  public question_order: number | null = null
  public related_order: number | null = null
  public related_to: number | null = null
  public value: any = null
  public score: number | null = null
  public values: Array<{ label: string; score: number }> | null = null
  public options: Record<string, any> | null = null

  constructor(data: Record<string, any> | null = null) {
    super(data)

    if (data !== null) {
      this.template_id = data.template_id ? Number.parseInt(data.template_id) : null
      this.survey_id = data.survey_id ? Number.parseInt(data.survey_id) : null
      this.type_id = typeof data.type_id !== "undefined" ? Number.parseInt(data.type_id) : null
      this.category = data.category ?? null
      this.component = data.component ?? null
      this.label = data.label ?? null
      this.description = data.description ?? null
      this.required = Boolean(data.required ?? false)
      this.order = data.order ?? null
      this.question_order = data.question_order ?? null
      this.related_to = data.related_to ? Number.parseInt(data.related_to) : null
      this.related_order = typeof data.related_order !== "undefined" ? Number.parseInt(data.related_order) : null
      this.score = typeof data.score !== "undefined" ? Number.parseFloat(data.score) : null
      this.values = data.values ?? null
      this.options = data.options ?? null

      if (data.value) {
        if (Array.isArray(data.value)) {
          this.value = data.value.map(val => {
            return isNumericString(val) ? Number.parseInt(val) : val
          })
        }
        else if (isNumericString(data.value)) {
          this.value = Number.parseInt(data.value)
        }
        else {
          this.value = data.value
        }
      }
    }
  }

  static generateFromType(
    type: Type,
    order: number,
  ): Question {
    return new Question(cloneDeep({
      type_id: type.id,
      category: type.category,
      component: type.component,
      label: type.label,
      description: null,
      required: type.required,
      order,
      value: type.value,
      values: type.values,
      options: type.options,
    }))
  }

  static generateRelated(question: Question, order: number): Question {
    const data: Record<string, any> = {
      type_id: question.type_id,
      category: question.category,
      component: question.component,
      label: question.label,
      description: null,
      required: question.required,
      order,
      value: question.value,
      score: question.score,
      values: question.values,
    }

    if (question.id !== null)
      data.related_to = question.id
    else
      data.related_order = question.order

    return new Question(data)
  }

  get isRelated(): boolean {
    return (
      this.component === 'MultipleRadioGroup'
      && this.related_order === null
      && this.related_to === null
    )
  }

  get hasRelation(): boolean {
    return this.related_order !== null || this.related_to !== null
  }

  setLabel(label: string): void {
    this.label = label
  }

  setDescription(description: string): void {
    this.description = description
  }

  setRequired(required: boolean): void {
    this.required = required
  }

  setScore(score: number | string): void {
    this.score = typeof score === 'string' ? Number.parseFloat(score) : score
  }

  setValue(value: any): void {
    this.value = value
  }

  addValues(label: string = '', score: string | number | null = null): void {
    if (!isArray(this.values))
      this.values = []

    score
      = typeof score === 'string' || typeof score === 'number'
        ? typeof score === 'string'
          ? Number.parseFloat(score)
          : score
        : this.values.length + 1

    this.values.push({
      label,
      score,
    })
  }

  setValues(index: number, key: 'label' | 'score', val: any = null): void {
    if (this.values && typeof this.values[index] !== 'undefined') {
      if (val === null) {
        delete this.values[index]

        return
      }

      if (key === 'label' && typeof val === 'string')
        this.values[index][key] = val
      else if (key === 'score' && typeof val === 'string')
        this.values[index][key] = Number.parseFloat(val)
    }
  }

  removeValues(index: number): void {
    if (this.values)
      this.values.splice(index, 1)
  }

  getOption(key: string, defaultValue: any = null): any {
    if (this.options && typeof this.options[key] !== 'undefined')
      return this.options[key]

    return defaultValue
  }

  setOption(key: string, val: any = null): void {
    if (this.options === null)
      this.options = {}

    if (val === null) {
      delete this.options[key]

      return
    }

    this.options[key] = val
  }

  getValueImage(defaultImageSrc: any = null): string {
    if (this.value)
      return `${APP_URL}/images/templates/value/${this.value}`

    return defaultImageSrc
  }

  getOptionImage(key: string = 'image', defaultImageSrc: any = null): string {
    if (this.getOption(key))
      return `${APP_URL}/images/templates/options/${this.getOption(key)}`

    return defaultImageSrc
  }

  get labelShowAble(): boolean {
    return !['MultipleRadioGroup'].includes(<string> this.component)
  }

  get isRenderAble(): boolean {
    return !(
      this.component === 'MultipleRadioGroup'
      && (this.related_to !== null || this.related_order !== null)
    )
  }
}

export default Question

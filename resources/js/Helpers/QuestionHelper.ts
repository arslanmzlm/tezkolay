import { isArray, orderBy } from 'lodash'
import { TYPE } from 'vue-toastification'
import type Type from '@/Models/Type'
import Question from '@/Models/Question'
import { toast } from '@/Helpers/Toast'
import { getI18n } from '@/plugins/i18n'

const { t } = getI18n().global

class QuestionHelper {
  public items: Question[] = [];

  * [Symbol.iterator](): Generator<Question, void, any> {
    yield * this.items
  }

  all(): Question[] {
    return this.items
  }

  getRenderAble(): Question[] {
    return this.items.filter((question: Question) => {
      return question.isRenderAble
    })
  }

  addFromFetch(rows: Array<Record<string, any>>) {
    if (isArray(rows) && rows.length) {
      rows.forEach(row => {
        this.items.push(new Question(row))
      })
    }
  }

  add(type: Type): void {
    this.items.push(
      Question.generateFromType(type, this.items.length + 1),
    )

    this.reOrder()
  }

  addMultiple(count: number = 1, type: Type): boolean {
    if (count < 1 || count > 50) {
      toast(t('errors.template.multiple_count_invalid'), TYPE.ERROR)

      return false
    }

    for (let i = 0; i < count; i++)
      this.add(type)

    return true
  }

  addRelated(question: Question): void {
    this.items.push(
      Question.generateRelated(question, this.items.length + 1),
    )

    this.reOrder()
  }

  getRelates(question: Question): Question[] {
    return this.items.filter((item: Question) => {
      return (
        item.order === question.order
        || (question.id !== null && item.id === question.id)
        || item.related_order === question.order
        || (question.id !== null && item.related_to === question.id)
      )
    })
  }

  getRelated(question: Question): Question[] {
    return this.items.filter((item: Question) => {
      return (
        item.related_order === question.order
        || (question.id !== null && item.related_to === question.id)
      )
    })
  }

  remove(question: Question): void {
    if (question.isRelated) {
      this.items = this.items.filter((item: Question) => {
        return (
          (item.order !== question.order
            || (question.id !== null && item.id !== question.id))
          && (item.related_order !== question.order
            || (question.id !== null && item.related_to !== question.id))
        )
      })
    }
    else {
      const index: number = this.items.findIndex(
        (item: Question): boolean => {
          return item.order === question.order
        },
      )

      this.items.splice(index, 1)
    }

    this.reOrder()
  }

  reOrder(): void {
    let order: number = 1
    let questionOrder: number = 1

    this.items.forEach((question: Question): void => {
      if (question.isRelated) {
        const relatedOrder: number = order

        this.getRelated(question).forEach((relatedQuestion: Question): void => {
          order++
          relatedQuestion.related_order = relatedOrder
          relatedQuestion.order = order
        })

        question.order = relatedOrder
        order++
      }
      else if (!question.hasRelation) {
        question.order = order
        order++
      }
    })

    this.items = orderBy(this.items, 'order')

    this.items.forEach((question: Question): void => {
      if (question.category === 'input') {
        question.question_order = questionOrder
        questionOrder++
      }
    })
  }

  removedType(typeId: number, mainTypeId: number) {
    this.items.forEach((question: Question) => {
      if (question.type_id === typeId)
        question.type_id = mainTypeId
    })
  }
}

export default QuestionHelper

import { concat } from 'lodash'
import Model from '@/Models/Model'
import Patient from '@/Models/Patient'
import Survey from '@/Models/Survey'

class Group extends Model {
  public name: string | null = null
  public size: number | null = null
  public user_id: number | null = null
  public workspace_name: number | null = null
  public patients: Patient[] = []
  public surveys: Survey[] = []
  public readonly patients_count: number = 0
  public readonly surveys_count: number = 0

  constructor(data: Record<string, any> | null = null) {
    super(data)

    if (data !== null) {
      this.name = data.name ?? null
      this.size = data.size ?? null
      this.user_id = data.user_id ?? null
      this.workspace_name = data.workspace_name ?? null
      this.patients_count = data.patients_count ?? 0
      this.surveys_count = data.surveys_count ?? 0

      if (data.patients && data.patients.length) {
        data.patients.forEach((item: Record<string, any>) => {
          this.patients.push(new Patient(item))
        })
      }

      if (data.surveys && data.surveys.length) {
        data.surveys.forEach((item: Record<string, any>) => {
          this.surveys.push(new Survey(item))
        })
      }
    }
  }

  getData(): Record<string, any> {
    return {
      name: this.name,
      size: this.size,
      patients: this.patients.map((patient: Patient): Record<string, any> => {
        return patient.getData()
      }),
      surveys: this.surveys.map((survey: Survey): Record<string, any> => {
        return survey.getData()
      }),
    }
  }

  getDataWithPatients(): Record<string, any> {
    return {
      size: this.size,
      patients: this.patients.map((patient: Patient): Record<string, any> => {
        return patient.getData()
      }),
    }
  }

  getDataWithSurveys(): Record<string, any> {
    return {
      surveys: this.surveys.map((survey: Survey): Record<string, any> => {
        return survey.getData()
      }),
    }
  }

  get nameLetters(): string {
    if (typeof this.name === 'string') {
      const match = this.name.match(/\b(\w)/gu)

      if (match)
        return (match[0] ?? '') + (match[1] ?? '')
    }

    return ''
  }

  fillPatients(): void {
    if (this.patients.length < <number> this.size) {
      const missing: number = <number> this.size - this.patients.length

      const newPatients: Patient[] = Array.from({ length: missing })
        .fill(null)
        .map(() => new Patient())

      this.patients = concat(this.patients, newPatients)
    }
    else if (this.patients.length > <number> this.size) {
      const missing: number = <number> this.size - this.patients.length

      this.patients.splice(missing)
    }
  }

  addPatient(data: Record<string, any> | null = null): Patient {
    const patient: Patient = new Patient(data ?? null)

    this.patients.push(patient)
    if (!this.size)
      this.size = 0

    this.size++

    return patient
  }

  removePatient(index: number): void {
    this.patients.splice(index, 1)
    if (this.size)
      this.size--
  }

  addSurvey(data: Record<string, any> | null = null): Survey {
    const survey: Survey = new Survey(data ?? null)

    this.surveys.push(survey)

    return survey
  }

  removeSurvey(index: number): void {
    this.surveys.splice(index, 1)
  }
}

export default Group

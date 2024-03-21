import Model from '@/Models/Model'

class Type extends Model {
  public readonly component: string | null = null
  public readonly category: string | null = null
  public label: string | null = null
  public description: string | null = null
  public required: boolean | null = false
  public order: number | null = null
  public value: any = null
  public values: Array<object> | null = null
  public options: object | null = null
  public user_id: number | null = null
  public main_type_id: number | null = null

  constructor(data: Record<string, any> | null = null) {
    super(data)

    if (data !== null) {
      this.component = data.component ?? null
      this.category = data.category ?? null
      this.label = data.label ?? null
      this.description = data.description ?? null
      this.required = data.required ?? null
      this.order = data.order ?? null
      this.value = data.value ?? null
      this.values = data.values ?? null
      this.options = data.options ?? null
      this.user_id = data.user_id ?? null
      this.main_type_id = data.main_type_id ?? null
    }
  }
}

export default Type

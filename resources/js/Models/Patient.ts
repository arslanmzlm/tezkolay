import Model from '@/Models/Model'

class Patient extends Model {
  public group_id: number | null = null
  public name: string | null = null
  public phone: string | null = null
  public contact_phone: string | null = null

  constructor(data: Record<string, any> | null = null) {
    super(data)

    if (data !== null) {
      this.group_id = data.group_id ? Number.parseInt(data.group_id) : null
      this.name = data.name ?? null
      this.phone = data.phone ?? null
      this.contact_phone = data.contact_phone ?? null
    }
  }

  getData(): Record<string, any> {
    return {
      name: this.name,
      phone: this.phone,
      contact_phone: this.contact_phone,
    }
  }

  get label(): string {
    return this.name ? `${this.name} - ${this.phone}` : `${this.phone}`
  }
}

export default Patient

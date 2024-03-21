import { DateTime } from 'luxon'

class Model {
  public id: number | null = null
  public created_at: DateTime | string | null = null
  public updated_at: DateTime | string | null = null

  constructor(data: Record<string, any> | null = null) {
    if (data !== null) {
      this.id = data.id ?? null
      this.created_at = data.created_at ? DateTime.fromISO(data.created_at) : null
      this.updated_at = data.updated_at ? DateTime.fromISO(data.updated_at) : null
    }
  }

  getData(): Record<string, any> {
    return {
      ...this,
    }
  }
}

export default Model

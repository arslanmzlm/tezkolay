import { DateTime } from 'luxon'
import { APP_LOCALE } from '@core/config'

export function dateToFullString(date: DateTime | string): string {
  if (!(date instanceof DateTime))
    date = DateTime.fromISO(date)

  if (date.isValid) {
    return date.setLocale(APP_LOCALE)
      .toLocaleString(DateTime.DATE_FULL)
  }

  return ''
}

export function dateTimeToFullString(date: DateTime | string): string {
  if (!(date instanceof DateTime))
    date = DateTime.fromISO(date)

  if (date.isValid) {
    return date.setLocale(APP_LOCALE)
      .toLocaleString({ ...DateTime.DATETIME_FULL, timeZoneName: undefined })
  }

  return ''
}

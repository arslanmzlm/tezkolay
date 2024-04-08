export const Skins = {
  Default: 'default',
  Bordered: 'bordered',
} as const

export const Theme = {
  Light: 'light',
  Dark: 'dark',
  System: 'system',
} as const

export const Layout = {
  Vertical: 'vertical',
  Horizontal: 'horizontal',
  Collapsed: 'collapsed',
} as const

export const Direction = {
  Ltr: 'ltr',
  Rtl: 'rtl',
} as const

export enum IMAGE_POSITION {
  TOP = 'top',
  RIGHT = 'right',
  BOTTOM = 'bottom',
  LEFT = 'left',
}

export const IMAGE_POSITIONS = Object.values(IMAGE_POSITION)

export enum LIST_STYLE {
  NONE = 'none',
  DISC = 'disc',
  CIRCLE = 'circle',
  SQUARE = 'square',
  DISCLOSURE_CLOSED = 'disclosure-closed',
  DISCLOSURE_OPEN = 'disclosure-open',
  DECIMAL = 'decimal',
  DECIMAL_LEADING_ZERO = 'decimal-leading-zero',
  UPPER_LATIN = 'upper-latin',
  LOWER_LATIN = 'lower-latin',
  UPPER_ROMAN = 'upper-roman',
  LOWER_ROMAN = 'lower-roman',
}

export const LIST_STYLES: LIST_STYLE[] = Object.values(LIST_STYLE)

export const LIST_ORDERED_STYLES: string[] = [
  LIST_STYLE.DECIMAL,
  LIST_STYLE.DECIMAL_LEADING_ZERO,
  LIST_STYLE.UPPER_LATIN,
  LIST_STYLE.LOWER_LATIN,
  LIST_STYLE.UPPER_ROMAN,
  LIST_STYLE.LOWER_ROMAN,
]

export const LIST_UNORDERED_STYLES: string[] = [
  LIST_STYLE.NONE,
  LIST_STYLE.DISC,
  LIST_STYLE.CIRCLE,
  LIST_STYLE.SQUARE,
  LIST_STYLE.DISCLOSURE_CLOSED,
  LIST_STYLE.DISCLOSURE_OPEN,
]

export enum SURVEY_STATE {
  CREATED = 'created',
  INITIALIZED = 'initialized',
  SENT = 'sent',
  COMPLETED = 'completed',
}

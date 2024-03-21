import { getI18n } from '@/plugins/i18n'

const { t } = getI18n().global

export default [
  {
    title: t('titles.homepage'),
    href: route('app.dashboard.index'),
    component: 'App/Dashboard',
    icon: { icon: 'tabler-smart-home' },
  },
  {
    title: t('titles.workspaces'),
    href: route('app.workspace.list'),
    component: 'App/Workspace/List',
    icon: { icon: 'tabler-color-swatch' },
  },
  {
    title: t('titles.templates'),
    href: route('app.template.list'),
    component: 'App/Template/List',
    icon: { icon: 'tabler-clipboard-copy' },
  },
]

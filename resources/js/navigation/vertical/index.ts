export default [
  {
    title: 'titles.homepage',
    href: route('app.dashboard.index'),
    component: 'App/Dashboard',
    icon: { icon: 'tabler-smart-home' },
  },
  {
    title: 'titles.workspaces',
    href: route('app.workspace.list'),
    component: 'App/Workspace/List',
    icon: { icon: 'tabler-color-swatch' },
  },
  {
    title: 'titles.templates',
    href: route('app.template.list'),
    component: 'App/Template/List',
    icon: { icon: 'tabler-clipboard-copy' },
  },
  {
    title: 'titles.surveys',
    href: route('app.survey.list'),
    component: 'App/Survey/List',
    icon: { icon: 'tabler-clipboard-data' },
  },
]

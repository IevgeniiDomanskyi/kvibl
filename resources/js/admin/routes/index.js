import Vue from 'vue'
import VueRouter from 'vue-router'
import pages from '../pages'

Vue.use(VueRouter)

const routes = [
  {
    path: '/admin/docs',
    name: 'Documentation',
    component: pages.Documentation,
  }, {
    path: '/admin/',
    component: pages.Login,
    children: [
      {
        path: '',
        component: pages.Layout,
        children: [
          {
            path: '',
            name: 'Dashboard',
            component: pages.Dashboard,
          }, {
            path: 'locales',
            name: 'Locales',
            component: pages.Locales,
          }, {
            path: 'categories',
            name: 'Categories',
            component: pages.Categories,
          }, {
            path: 'users',
            name: 'Users',
            component: pages.Users,
          }, {
            path: 'categories/:id',
            name: 'Category',
            component: pages.CategoryDetails,
          }
        ]
      },
    ]
  }, {
    path: '*',
    name: '404',
    component: pages.NotFound,
  },
]

const router = new VueRouter({
    mode: 'history',
    routes,
})

export default router

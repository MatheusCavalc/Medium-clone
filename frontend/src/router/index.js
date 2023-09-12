import { createRouter, createWebHistory } from 'vue-router'

let authUser = localStorage.getItem("bearerToken") === null ? false : true

const routes = [
  { //login
    path: '/login',
    name: 'login',
    component: () => import(/* webpackChunkName: "about" */ '../views/Auth/LoginView.vue'),
    beforeEnter: (to, from, next) => {
      if (authUser) {
        return next({
          name: 'home'
        })
      }

      next()
    }
  },
  { //register
    path: '/register',
    name: 'register',
    component: () => import(/* webpackChunkName: "about" */ '../views/Auth/RegisterView.vue'),
    beforeEnter: (to, from, next) => {
      if (authUser) {
        return next({
          name: 'home'
        })
      }

      next()
    }
  },
  { //home (guest)
    path: '/home',
    name: 'index',
    component: () => import(/* webpackChunkName: "about" */ '../views/App/GuestHome.vue'),
    beforeEnter: (to, from, next) => {
      if (authUser) {
        return next({
          name: 'home'
        })
      }

      next()
    }
  },
  { //home (auth)
    path: '/',
    name: 'home',
    component: () => import(/* webpackChunkName: "about" */ '../views/App/AuthHome.vue'),
    beforeEnter: (to, from, next) => {
      if (!authUser) {
        return next({
          name: 'index'
        })
      }

      next()
    }
  },
  { //home following (auth)
    path: '/following',
    name: 'following',
    component: () => import(/* webpackChunkName: "about" */ '../views/App/FollowingHome.vue'),
    beforeEnter: (to, from, next) => {
      if (!authUser) {
        return next({
          name: 'index'
        })
      }

      next()
    }
  },
  { //new story (editor)
    path: '/new-story',
    name: 'new_story',
    component: () => import(/* webpackChunkName: "about" */ '../views/App/Editor/EditorView.vue'),
    beforeEnter: (to, from, next) => {
      if (!authUser) {
        return next({
          name: 'login'
        })
      }

      next()
    }
  },
  { //edit story (editor)
    path: '/p/:id/edit',
    name: 'edit_story',
    component: () => import(/* webpackChunkName: "about" */ '../views/App/Editor/EditorEditView.vue'),
    beforeEnter: (to, from, next) => {
      if (!authUser) {
        return next({
          name: 'index'
        })
      }

      next()
    }
  },
  { //confirm story (editor)
    path: '/confirm-story',
    name: 'confirm_story',
    component: () => import(/* webpackChunkName: "about" */ '../views/App/Editor/ConfirmStoryView.vue'),
    beforeEnter: (to, from, next) => {
      if (!authUser) {
        return next({
          name: 'login'
        })
      }

      next()
    }
  },
  { //read story
    path: '/story/:slug/:id',
    name: 'story',
    component: () => import(/* webpackChunkName: "about" */ '../views/App/StoryView.vue'),
    beforeEnter: (to, from, next) => {
      if (!authUser) {
        return next({
          name: 'index'
        })
      }

      next()
    }
  },
  { //profile
    path: '/profile',
    name: 'profile',
    component: () => import(/* webpackChunkName: "about" */ '../views/App/Profile/ProfileIndex.vue'),
    beforeEnter: (to, from, next) => {
      if (!authUser) {
        return next({
          name: 'index'
        })
      }

      next()
    }
  },
  { //profile
    path: '/me/settings/account',
    name: 'setting-account',
    component: () => import(/* webpackChunkName: "about" */ '../views/App/Profile/SettingAccount.vue'),
    beforeEnter: (to, from, next) => {
      if (!authUser) {
        return next({
          name: 'index'
        })
      }

      next()
    }
  },
  { //user page (other users)
    path: '/:username',
    name: 'user page',
    component: () => import(/* webpackChunkName: "about" */ '../views/App/User/UserIndex.vue'),
    beforeEnter: (to, from, next) => {
      if (!authUser) {
        return next({
          name: 'index'
        })
      }

      next()
    }
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router

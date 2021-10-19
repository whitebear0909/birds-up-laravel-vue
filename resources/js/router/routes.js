function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'welcome', component: page('welcome.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/about', name: 'about', component: page('About.vue') },
  { path: '/contactus', name: 'contact-us', component: page('ContactUs.vue') },
  { path: '/courseMetrics', name: 'course-metrics', component: page('CourseMetrics.vue') },
  { path: '/dogPerformance', name: 'dog-performance', component: page('DogPerformance.vue') },
  { path: '/mapCovey', name: 'map-covey', component: page('MapCovey.vue') },

  { 
    path: '/home', 
    component: page('home.vue'),
    children: [
      { path: '', redirect: { name: 'home.dashboard' } },
      { path: 'dashboard', name: 'home.dashboard', component: page('dashboard/Dashboard.vue') },
      { path: 'property', name: 'home.property', component: page('dashboard/Property.vue') },
      { path: 'courses', name: 'home.courses', component: page('dashboard/Courses.vue') },
      { path: 'huntergroup', name: 'home.huntergroup', component: page('dashboard/HunterGroup.vue') },
      { path: 'hunters', name: 'home.hunters', component: page('dashboard/Hunters.vue') },
      { path: 'dogs', name: 'home.dogs', component: page('dashboard/Dogs.vue') },
    ] 
  },

  { path: '*', component: page('errors/404.vue') }
]

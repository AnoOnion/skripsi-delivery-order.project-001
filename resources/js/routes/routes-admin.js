function page (path) {
    return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
    /* Authenticate Admin Pages */
    {
        path: '/login', /* Done */
        name: 'admin.auth.login',
        meta: { title: 'Login Management' },
        component: page('admin/auth/Login.vue')
    },

    /* Forget Admin Password Pages */
    {
        path: '/password/reset', /* Done */
        name: 'admin.password.reset',
        meta: { title: 'Reset Password Management' },
        component: page('admin/auth/password/ForgetPassword.vue')
    },
    {
        path: '/password/reset/:token', /* Done */
        name: 'admin.password.verify',
        meta: { title: '' },
        component: page('admin/auth/password/PasswordReset.vue')
    },

    {
        path: '/email/check',
        name: 'admin.verify.check',
        meta: { title: '' },
        component: page('admin/auth/verification/CheckEmail.vue')
    },
    {
        path: '/email/expired',
        name: 'verify.expired',
        meta: { title: '' },
        component: page('admin/auth/verification/ExpiredEmailVerify.vue')
    },
    {
        path: '/email/verify/:id',
        name: 'verify.email',
        meta: { title: '' },
        component: page('user/auth/verification/VerifyAccount.vue')
    },

    {
        path: '/topup/success',
        name: 'topup.success',
        meta: { title: 'Topup - Success' },
        component: page('user/callback/Success.vue')
    },
    {
        path: '/topup/failed',
        name: 'topup.failed',
        meta: { title: 'Topup - Failed' },
        component: page('user/callback/Failed.vue')
    },

    /* Dashboard Admin */
    {
        path: '/',
        component: page('admin/App.vue'),
        children: [
            {
                path: '',
                name: 'admin.dashboard.index',
                meta: { title: 'Dashboard - Home' },
                component: page('admin/pages/Home.vue'),
            },
            {
                path: 'courier',
                name: 'admin.dashboard.courier',
                meta: { title: 'Dashboard - Courier' },
                component: page('admin/pages/Courier.vue'),
            },
            {
                path: 'transaction/:id?/:unique?',
                name: 'admin.dashboard.transaction',
                meta: { title: 'Dashboard - Transaction' },
                component: page('admin/pages/Transaction.vue'),
            },
            {
                path: 'information',
                name: 'admin.dashboard.information',
                meta: { title: 'Dashboard - Information' },
                component: page('admin/pages/Information.vue'),
            },
            {
                path: 'product/:id?',
                name: 'admin.dashboard.product',
                meta: { title: 'Dashboard - Product' },
                component: page('admin/pages/Product.vue'),
            },
            {
                path: 'vehicle/:id?',
                name: 'admin.dashboard.vehicle',
                meta: { title: 'Dashboard - Vehicle' },
                component: page('admin/pages/Vehicle.vue'),
            },
            {
                path: 'spending',
                name: 'admin.dashboard.spending',
                meta: { title: 'Dashboard - Spending' },
                component: page('admin/pages/Spending.vue'),
            },
            {
                path: 'member',
                name: 'admin.dashboard.member',
                meta: { title: 'Dashboard - Member' },
                component: page('admin/pages/Member.vue'),
            },
            {
                path: 'report',
                component: page('admin/pages/Report.vue'),
                children: [
                    {
                        path: 'product',
                        name: 'admin.dashboard.report.product',
                        meta: { title: 'Dashboard - Product' },
                        component: page('admin/pages/report/Product.vue'),
                    },
                    {
                        path: 'transaction',
                        name: 'admin.dashboard.report.transaction',
                        meta: { title: 'Dashboard - Transaction' },
                        component: page('admin/pages/report/Transaction.vue'),
                    },
                    {
                        path: 'vehicle/:id?',
                        name: 'admin.dashboard.report.vehicle',
                        meta: { title: 'Dashboard - Vehicle' },
                        component: page('admin/pages/report/Vehicle.vue'),
                    },
                ]
            },

            {
                path: 'setting',
                name: 'admin.dashboard.setting',
                meta: { title: 'Dashboard - Setting' },
                component: page('admin/pages/Setting.vue'),
            },
            {
                path: 'about',
                name: 'admin.dashboard.about',
                meta: { title: 'Dashboard - About' },
                component: page('admin/pages/About.vue'),
            }
        ]
    },

    /* Policy Pages */
    {
        path: '/terms',
        name: 'policy.terms',
        meta: { title: '' },
        component: page('user/auth/Register.vue')
    },
    {
        path: '/privacy-policy',
        name: 'policy.privacy',
        meta: { title: '' },
        component: page('user/auth/Register.vue')
    },

    /* Page not found */
    {
        path: '/:catchAll(.*)',
        component: page('errors/404.vue')
    }
]

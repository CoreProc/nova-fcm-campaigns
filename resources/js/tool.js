Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'nova-fcm-campaigns',
            path: '/nova-fcm-campaigns',
            component: require('./components/Tool'),
        },
    ])
})

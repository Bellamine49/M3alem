const CACHE = 'm3alem-v2';
const STATIC = [
    '/', '/categories', '/workers',
    '/icon-192x192.png', '/icon-512x512.png',
    '/logo_M3alem_transparent.png',
];

self.addEventListener('install', e => {
    self.skipWaiting();
    e.waitUntil(caches.open(CACHE).then(c => c.addAll(STATIC)));
});

self.addEventListener('activate', e => {
    e.waitUntil(
        caches.keys().then(keys => Promise.all(
            keys.filter(k => k !== CACHE).map(k => caches.delete(k))
        ))
    );
});

self.addEventListener('fetch', e => {
    const { request } = e;
    if (request.method !== 'GET') return;
    if (request.url.includes('/login') || request.url.includes('/register')) {
        e.respondWith(fetch(request).catch(() => caches.match(request)));
        return;
    }
    e.respondWith(
        caches.match(request).then(cached => {
            const fetchPromise = fetch(request).then(res => {
                if (res.ok) {
                    const clone = res.clone();
                    caches.open(CACHE).then(c => c.put(request, clone));
                }
                return res;
            }).catch(() => cached);
            return cached || fetchPromise;
        })
    );
});

self.addEventListener('push', e => {
    let data = { title: 'M3alem', body: 'New notification', icon: '/icon-192x192.png' };
    if (e.data) {
        try { data = { ...data, ...e.data.json() }; } catch (_) { data.body = e.data.text(); }
    }
    e.waitUntil(
        self.registration.showNotification(data.title, {
            body: data.body,
            icon: data.icon || '/icon-192x192.png',
            badge: '/icon-192x192.png',
            vibrate: [200, 100, 200],
            data: data.data || {},
            actions: data.actions || [],
        })
    );
});

self.addEventListener('notificationclick', e => {
    e.notification.close();
    const url = e.notification.data?.url || '/';
    e.waitUntil(clients.openWindow(url));
});

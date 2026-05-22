const CACHE = 'm3alem-v1';
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
        e.respondWith(networkOrCache(request));
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

function networkOrCache(req) {
    return fetch(req).catch(() => caches.match(req));
}

// Autotrack Modules
ga("require", "eventTracker");
ga("require", "outboundLinkTracker");
ga("require", "urlChangeTracker");
ga("require", "maxScrollTracker");
ga("require", "pageVisibilityTracker");
ga("require", "socialWidgetTracker");
ga("require", "impressionTracker");

window.dataLayer = window.dataLayer || [];
window.ga = window.ga || function() {
    (ga.q = ga.q || []).push(arguments);
};
ga.l =+ new Date();
function gtag() {
    dataLayer.push(arguments);
}
ga("send", "pageview");

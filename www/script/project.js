/**
 * Used to resize the iframe for embebbed projects.
 *
 * @param obj The iframe.
 */
function resizeIframe(obj) {
    obj.style.height = (obj.contentWindow.document.body.scrollHeight + 100) + 'px';
    obj.style.width = (obj.contentWindow.document.body.scrollWidth + 100) + 'px';
}

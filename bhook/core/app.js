let blogPost = [];
for (let i = 0; i &lt; $(".content").length; i++) {
    let content = $(".content")[i];
    blogPost.push({
        image: content.getAttribute("img"),
        title: content.getAttribute("title"),
        date: content.getAttribute("date"),
        link: content.getAttribute("link"),
        content: content.getAttribute("content"),
    });
}
$(".tmp").remove();
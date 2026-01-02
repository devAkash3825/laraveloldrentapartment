var nestedTabSelect = (tabsElement, currentElement) => {
    const tabs = tabsElement ?? "ul.tabs";
    const currentClass = currentElement ?? "active";

    $(tabs).each(function () {
        let $active,
            $content,
            $links = $(this).find("a");

        $active = $(
            $links.filter('[href="' + location.hash + '"]')[0] || $links[0]
        );
        $active.addClass(currentClass);

        $content = $($active[0].hash);
        $content.addClass(currentClass);

        $links.not($active).each(function () {
            $(this.hash).removeClass(currentClass);
        });

        $(this).on("click", "a", function (e) {
            // Make the old tab inactive.
            $active.removeClass(currentClass);
            $content.removeClass(currentClass);

            // Update the variables with the new link and content
            $active = $(this);
            $content = $(this.hash);

            // Make the tab active.
            $active.addClass(currentClass);
            $content.addClass(currentClass);

            e.preventDefault();
        });
    });
};

nestedTabSelect("ul.tabs", "active");
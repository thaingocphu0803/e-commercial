/**
 * Modal handling logic with jQuery.
 * Supports open/close via buttons and clicking outside the modal content.
 */
(function handleModal() {
    $(document).on("click", function (e) {
        let $target = $(e.target);

        // --- Open modal (find parent element that is close  data-open-modal)
        let $openBtn = $target.closest("[data-open-modal]");
        if ($openBtn.length) {
            let modalId = $openBtn.data("openModal");

            setTimeout(() => {
                $(modalId).css("display", "block");
            }, 1000);
            return;

        }

        // --- Close modal (find parent element that is closed  data-close-modal)
        let $closeBtn = $target.closest("[data-close-modal]");
        if ($closeBtn.length) {
            let modalId = $closeBtn.data("closeModal");
            $(modalId).css("display", "none");
            return;
        }

        // --- Close modal when click overlay
        let $modal = $target.closest(".modal");
        if ($modal.length && !$target.closest(".modal-container").length) {
            $modal.css("display", "none");
        }
    });
})();

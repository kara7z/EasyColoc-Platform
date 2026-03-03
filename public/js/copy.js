(function() {
    function fallbackCopy(text) {
        const textarea = document.createElement("textarea");
        textarea.value = text;
        textarea.setAttribute("readonly", "");
        textarea.style.position = "fixed";
        textarea.style.left = "-9999px";
        textarea.style.top = "0";
        document.body.appendChild(textarea);

        textarea.focus();
        textarea.select();
        textarea.setSelectionRange(0, textarea.value.length);

        let ok = false;
        try {
            ok = document.execCommand("copy");
        } catch (e) { }

        document.body.removeChild(textarea);
        return ok;
    }

    async function copy(text) {
        try {
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(text);
                return true;
            }
        } catch (e) { }
        return fallbackCopy(text);
    }

    document.addEventListener("click", async (e) => {
        const btn = e.target.closest("[data-copy]");
        if (!btn) return;

        const text = btn.getAttribute("data-copy") || "";
        if (!text) return;

        const ok = await copy(text);

        // small feedback
        const oldText = btn.textContent;
        btn.textContent = ok ? "Copié" : "Erreur";
        setTimeout(() => {
            btn.textContent = oldText;
        }, 900);
    });
})();

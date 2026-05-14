import { onMounted, ref } from 'vue';

/**
 * useReveal Composable
 * 
 * Handles revealing elements as they enter the viewport.
 * 
 * @param {Object} options - IntersectionObserver options.
 * @returns {Object} { galleryRefs } - Refs to be attached to elements.
 */
export function useReveal(options = { threshold: 0.1 }) {
    const galleryRefs = ref([]);

    onMounted(() => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('reveal-active');
                    // Once revealed, we can stop observing this specific element
                    observer.unobserve(entry.target);
                }
            });
        }, options);

        galleryRefs.value.forEach((el) => {
            if (el) observer.observe(el);
        });
    });

    return { galleryRefs };
}

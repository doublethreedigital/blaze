import Blaze from './components/Blaze.vue'
import Component from '../../vendor/statamic/cms/resources/js/components/Component'

Statamic.booting(() => {
    Statamic.$components.register('blaze', Blaze)

    Statamic.$app.data.appendedComponents.push(
        new Component(`appended-blaze`, 'blaze', {})
    )
})

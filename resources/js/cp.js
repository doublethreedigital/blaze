import Zippy from './components/Zippy.vue'
import Component from '../../vendor/statamic/cms/resources/js/components/Component'

Statamic.booting(() => {
    Statamic.$components.register('zippy', Zippy)

    Statamic.$app.data.appendedComponents.push(
        new Component(`appended-zippy`, 'zippy', {})
    )
})

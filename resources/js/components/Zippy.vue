<template>
    <modal
        v-if="open"
        name="zippy"
        width="510"
        height="auto"
        :adaptive="true"
        :pivotY=".1"
        @closed="open = false"
        v-on-clickaway="close"
    >
        <div
            class="bg-grey-20 border-b text-center"
        >
            <input
                type="text"
                class="p-2 text-lg w-full bg-transparent focus:outline-none"
                v-model="query"
                placeholder="Looking for something?"
                autofocus
            >
        </div>

        <ul v-if="results.length" class="flex flex-col max-h-screen-1/2 overflow-y-scroll">
            <a
                v-for="result in results"
                :key="result.url"
                class="p-2 focus:bg-grey-30 focus:outline-none text-grey-80 hover:text-grey-80 w-full flex flex-col"
                :href="result.url"
                :target="result.target"
            >
                <span
                    class="font-medium flex items-center"
                    style="letter-spacing: -0.01em;"
                    tabindex="-1"
                >
                    <span
                        v-if="result.icon"
                        v-html="result.icon"
                        :title="result.title"
                        class="mr-1 w-4"
                    ></span>

                    <span
                        v-text="result.title"
                    ></span>
                </span>

                <a
                    v-if="result.parent"
                    class="text-xs text-grey-70 hover:text-blue focus:outline-none"
                    :href="result.parent.url"
                    tabindex="-1"
                >
                    {{ result.parent.title }}
                </a>
            </a>
        </ul>

        <div v-if="dump" class="max-h-screen-1/2 overflow-y-scroll">
            <div v-html="dump"></div>
        </div>
    </modal>
</template>

<script>
import axios from 'axios'
import { mixin as clickaway } from 'vue-clickaway'

export default {
    name: 'zippy',

    mixins: [
        clickaway,
    ],

    data() {
        return {
            open: false,
            query: null,
            results: [],
            dump: null,
        }
    },

    mounted() {
        this.setupKeybindings()
    },

    methods: {
        setupKeybindings() {
            document.addEventListener('keydown', (event) => {
                // CMD + P
                if (event.metaKey && event.code === 'KeyP') {
                    event.preventDefault()

                    this.open = !this.open
                }

                // Escape
                if (this.open && event.code === 'Escape') {
                    this.open = false
                }
            })
        },

        getResults() {
            if (! this.query) {
                this.results = []
            }

            axios.post(cp_url('zippy'), {
                query: this.query,
            }).then((response) => {
                if (typeof response.data === 'string') {
                    this.results = []
                    this.dump = response.data

                    return
                }

                this.results = response.data
                this.dump = null
            }).catch((error) => {
                this.results = []
                this.dump = null
            })
        },

        close() {
            // this.open = false
        },
    },

    watch: {
        query(value) {
            this.getResults()
        },
    },
}
</script>

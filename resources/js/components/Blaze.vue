<template>
  <modal
    v-if="open"
    name="blaze"
    width="510"
    height="auto"
    :adaptive="true"
    :pivotY="0.1"
    @closed="open = false"
    v-on-clickaway="close"
  >
    <div class="bg-grey-20 border-b text-center">
      <input
        id="blaze-input"
        type="text"
        class="p-2 text-lg w-full bg-transparent focus:outline-none"
        v-model="query"
        placeholder="Looking for something?"
        autofocus
      />
    </div>

    <ul
      v-if="results.length"
      id="blaze-result-list"
      class="flex flex-col max-h-screen-1/2 overflow-y-scroll"
    >
      <a
        v-for="result in results"
        :key="result.url"
        class="p-2 focus:bg-grey-30 focus:outline-none text-grey-80 hover:text-grey-80 focus:text-grey-80 w-full flex flex-col"
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

          <span v-text="result.title"></span>
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
import axios from "axios";
import { mixin as clickaway } from "vue-clickaway";

export default {
  name: "blaze",

  mixins: [clickaway],

  data() {
    return {
      open: false,
      query: null,
      results: [],
      dump: null,
      config: null,
      focusIndex: null,
    };
  },

  mounted() {
    this.getConfig();
  },

  methods: {
    getConfig() {
      axios
        .get(cp_url("blaze/config"))
        .then((response) => {
          this.config = response.data;

          this.setupKeybindings();
        })
        .catch((error) => {
          this.$toast.error("Blaze failed to get config");
        });
    },

    setupKeybindings() {
      document.addEventListener("keydown", (event) => {
        // CMD + P
        if (
          event.metaKey &&
          event.key == this.config.config.keyboard_shortcut.toLowerCase()
        ) {
          event.preventDefault();

          this.open = !this.open;
          this.query = null;
        }

        // Escape
        if (this.open && event.code === "Escape") {
          this.open = false;
        }

        // Down arrow
        if (this.open && event.code === "ArrowDown") {
          event.preventDefault();

          const results = document.getElementById("blaze-result-list")
            ?.children;

          if (results && this.focusIndex + 1 > results.length - 1) {
            return;
          }

          if (this.focusIndex == null) {
            results[0].focus();

            this.focusIndex = 0;

            return;
          }

          results[this.focusIndex + 1].focus();

          this.focusIndex = this.focusIndex + 1;
        }

        // Up arrow
        if (this.open && event.code === "ArrowUp") {
          event.preventDefault();

          const results = document.getElementById("blaze-result-list")
            ?.children;

          if (results && this.focusIndex - 1 < 0) {
            return;
          }

          results[this.focusIndex - 1].focus();

          this.focusIndex = this.focusIndex - 1;
        }
      });
    },

    getResults() {
      this.focusIndex = null;

      if (!this.query) {
        this.results = [];
      }

      axios
        .post(cp_url("blaze"), {
          query: this.query,
        })
        .then((response) => {
          if (typeof response.data === "string") {
            this.results = [];
            this.dump = response.data;

            return;
          }

          this.results = response.data;
          this.dump = null;
        })
        .catch((error) => {
          this.results = [];
          this.dump = null;
        });
    },

    close() {
      // this.open = false
    },
  },

  watch: {
    open(value) {
      if (value === true) {
        let openInputTimer = setInterval(() => {
          if (document.getElementById("blaze-input")) {
            document.getElementById("blaze-input").autofocus;
            document.getElementById("blaze-input").focus();

            clearInterval(openInputTimer);
          }
        }, 100);
      }
    },

    query(value) {
      this.getResults();
    },
  },
};
</script>

<style>
/* Please don't hunt me down and tell me off, this is GOOD css btw. Thanks and goodbye. */

[data-modal="blaze"] .v--modal-box {
  top: 79px !important;
}
</style>

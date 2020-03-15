<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        template: `
		    <div class="timer">{{ time | prettify }}</div>
        `,
        props: [
            'time',
            
        ],
        data() {
            return {
                isRunning: false,
                minutes:0,
                secondes:0,
                time:0,
                timer:null,
            }
        },  
        computed: {
            prettyTime () {
                let time = this.time / 60
                let minutes = parseInt(time)
                let secondes = Math.round((time - minutes) * 60)
                return minutes+":"+secondes
		    }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            setTime (payload) {
			    this.time = (payload.minutes * 60 + payload.secondes)
            },
            reset () {
                this.stop()
                this.time = 0
                this.secondes = 0
                this.minutes = 0
            },
            start () {
                this.isRunning = true
                if (!this.timer) {
                    this.timer = setInterval( () => {
                            if (this.time > 0) {
                                this.time--
                            } else {
                                clearInterval(this.timer)
                                this.sound.play()
                                this.reset()
                            }
                    }, 1000 )
                }
            },
            stop () {
                this.isRunning = false
                clearInterval(this.timer)
                this.timer = null
		    },
        },
        filters: {
            prettify : function(value) {
                let data = value.split(':')
                let minutes = data[0]
                let secondes = data[1]
                if (minutes < 10) {
                        minutes = "0"+minutes
                }
                if (secondes < 10) {
                        secondes = "0"+secondes
                }
                return minutes+":"+secondes
            }
        }
    }
</script>

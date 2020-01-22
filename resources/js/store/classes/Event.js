class Event {
  constructor() {
    this.id = null
    this.event = '',
    this.date_from = '',
    this.date_to = '',
    this.days = {
      mon: false, tue: false, wed: false, thu: false, fri: false, sat: false, sun: false,
    }
  }

  static fromJson(data) {
    let event = new Event()

    event.id = data.id
    event.event = data.event
    event.date_from = data.date_from
    event.date_to = data.date_to
    event.days = data.days

    return event
  }
}

export default Event

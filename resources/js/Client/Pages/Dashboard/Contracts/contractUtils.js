export const tabledHead = [
  {
    title: 'Name',
    value: 'name',
    slot: 'name',
    main: true,
  },
  {
    title: 'Date viewed',
    value: 'date',
    slot: 'date',
    sortable: false
  },
  {
    title: 'Insurance company',
    value: 'insurance',
    slot: 'insurance',
    sortable: false
  },
  {
    title: 'Homeowner email',
    value: 'homeowner',
    slot: 'homeowner',
    sortable: false
  },
]

/* just preview table */
export const placeholderData = {
  "current_page": 1,
  "data": [
      {
          "id": "97f120b8-8cf1-4fa7-97b4-f4b7c59eff5b",
          "name": "Hello contract",
          "date": "2022/11/04",
          "homeowner": "admin@example.net",
          "insurance": "ASESUISA"
      },
      {
          "id": "97f0b0bd-60c2-4704-9c8f-2b2c14eed5fe",
          "name": "test contract",
          "date": "2022/10/25",
          "homeowner": "admin@example.net",
          "insurance": "ASESUISA"
      }
  ],
  "from": 1,
  "links": [
      {
          "url": null,
          "label": "&laquo; Previous",
          "active": false
      },
      {
          "url": "http://127.0.0.1:8081/dashboard/builder?page=1",
          "label": "1",
          "active": true
      },
      {
          "url": null,
          "label": "Next &raquo;",
          "active": false
      }
  ],
  "to": 2,
  "total": 2
}
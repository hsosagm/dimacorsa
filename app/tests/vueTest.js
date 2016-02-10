var name = event.target.name // On input
var name = event.target.attributes['name'].value // On td


Form submit
e.preventDefault()
type: e.target.method,
url:  e.target.action,
data: $(e.target).serialize(),
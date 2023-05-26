let fullPlace = 100;
let midPlace = fullPlace*.4;
let minPlace = fullPlace*.15;

//////////////
//FUNCTIONS//
/////////////
const getRandomInt = (max)=>Math.floor(Math.random() * Math.floor(max))
const getDate = (date)=>date.toISOString().split("T")[0]

function setDataHours() {
 let hours = ["11:00:00","12:00:00","13:00:00","14:00:00","19:00:00","20:00:00","21:00:00","22:00:00"];
 let rtnObject = {};
 hours.map(x=>Object.defineProperty(rtnObject,x,{value:getRandomInt(fullPlace),enumerable:true,writable:true}));
 return rtnObject
};
function setData() {
 let date = new Date();
 let data = {date:{}};
 for (let i=0;i<100;i++) {
  data.date[getDate(date)] = {hour:setDataHours()};
  date.setDate(date.getDate()+1);
 }
 return data
};
const data = setData();

class Booking extends React.Component {
 constructor(props) {
  super(props);
  this.inputMax = 10;
  this.bodiesMax = 8;
  this.state = {
   days: ["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"],
   months: ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Décembre"],
   bodies: 2,
   reservation: "",
   hour: ""
  };
  this.addBody = this.addBody.bind(this);
  this.subBody = this.subBody.bind(this);
  this.setReservation = this.setReservation.bind(this);
  this.setHour = this.setHour.bind(this);
 };
 addBody() {
  if (this.state.bodies<this.inputMax){
   this.setState({bodies: this.state.bodies+1})
  }
 };
 subBody() {
  if (this.state.bodies>1){
   this.setState({bodies: this.state.bodies-1})
  }
 };
 setHour(hour) {
  this.setState({hour: hour})
 };
 setReservation() {
  if (this.state.hour != "") {
   if ((this.state.bodies <= this.bodiesMax) && (this.state.bodies <= data.date[getDate(this.props.date)].hour[this.state.hour])) {
    this.setState({reservation: "Validation pour "+this.state.hour})
   }else {
    this.setState({reservation: "NON Validate"})
   }
  }else {
   this.setState({reservation : "Selectionnez une heure de réservation."})
  }
 };
 componentDidUpdate(prevProps, prevState) {
  if (getDate(this.props.date) !== getDate(prevProps.date)) {this.setHour("")}; //reset sélection quand la date change
  if (this.state.bodies !== prevState.bodies) {
   if (data.date[getDate(this.props.date)].hour[this.state.hour]-this.state.bodies < 0 || 
       this.state.bodies>this.bodiesMax) {this.setHour("")} // permet de désélectionner si augmente personne non dispo et déjà sélectionné
  }
 };
 render() {
  return (
  <div className="RESERVATION">
   <div className="RESERVATION-HEADER">{
    this.state.days[this.props.date.getDay()] + " " + 
    this.props.date.getDate() + " " + 
    this.state.months[this.props.date.getMonth()] + " " + 
    this.props.date.getFullYear()
   }</div>
   <div className="RESERVATION-PEOPLE"><p>Nombre de personne</p></div>
   <div>
    <input className="RESERVATION-PEOPLE-INPUT" type="number" min="1" max="10" value={this.state.bodies}/>
    <button className="RESERVATION-PEOPLE-BTN" onClick={this.addBody}>+</button>
    <button className="RESERVATION-PEOPLE-BTN" onClick={this.subBody}>-</button>
   </div>
   <div>{
    Object.keys(data.date[getDate(this.props.date)].hour).map(
     x=><button 
      onClick = {data.date[getDate(this.props.date)].hour[x]-this.state.bodies >= 0 && this.state.bodies<=this.bodiesMax ? ()=>this.setHour(x) : ""}
      className = {
       (data.date[getDate(this.props.date)].hour[x]-this.state.bodies < 0 ? "RESERVATION-HOUR-FREEZE " :
       "RESERVATION-HOUR " + (data.date[getDate(this.props.date)].hour[x]-this.state.bodies < minPlace ? "RESERVATION-HOUR-MIN " :
       (data.date[getDate(this.props.date)].hour[x]-this.state.bodies < midPlace ? "RESERVATION-HOUR-MID " : "RESERVATION-HOUR-NORMAL "))) +
       (this.state.hour == x ? "RESERVATION-HOUR-SELECTED " : "")}
    >{x}</button>)
   }</div>
   {this.state.bodies>this.bodiesMax ? <p>Impossible de réserver pour un groupe de plus de 8 personnes</p> : <button className="RESERVATION-HOUR" onClick={this.setReservation}>Valider</button>}
   <div>{this.state.reservation}</div>
  </div>
  )
 }
}

class Calendar extends React.Component {
 constructor(props) {
  super(props);  
  this.today = new Date();
  this.today.setHours(0);
  this.min = new Date(this.today.valueOf());
  this.min.setDate(1); // minimum premier jour du mois actuel
  this.max = new Date();
  this.max.setMonth(this.max.getMonth()+3); // maximum 3 mois après la aujourd'hui 
  this.state = {
   months: ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Décembre"],
   days: ["Di","Lu","Ma","Me","Je","Ve","Sa"],
   date: new Date(),
   selectedDate: new Date()
  };
  this.addMonth = this.addMonth.bind(this);
  this.subMonth = this.subMonth.bind(this);
  this.renderDays = this.renderDays.bind(this);
  this.selectDate = this.selectDate.bind(this);
 };
 addMonth(){
  let testDate = new Date(this.state.date);
  testDate.setDate(1); // règle pb si sélection supérieur à max +1 mois
  testDate.setMonth(testDate.getMonth()+1);
  if (this.max.valueOf()>=testDate.valueOf()){
   this.state.date.setDate(1); // règle pb de nb jour dans l'addition d'un mois
   this.setState({date: new Date(this.state.date.setMonth(this.state.date.getMonth()+1))})
  }
 };
 subMonth(){
  let testDate = new Date(this.state.date);
  testDate.setMonth(testDate.getMonth()-1);
  if (this.min.valueOf()<=testDate.valueOf()){
   this.state.date.setDate(1); // règle pb de nb jour dans l'addition d'un mois
   this.setState({date: new Date(this.state.date.setMonth(this.state.date.getMonth()-1))})
  }
 };
 selectDate(date){
  this.setState({
   selectedDate: new Date(date),
   date: new Date(date)
  });
 };
 renderDays(){
  let date = new Date(this.state.date);
  let days = [];
  date.setDate(1);
  date.setHours(12); //fixe le pb avec le 1er un lundi
  date.setDate(-date.getDay()+1); // fixe la date au jour 0 de la semaine
  for(let i=0;i<42;i++){
   days.push(<div 
    className={"CALENDAR-WEEK-ITEM " +
    (date.getMonth()!=this.state.date.getMonth() ? "CALENDAR-DAY-WRONG " : "" ) +// pas dans le mois
    ((date.valueOf()>=this.today.valueOf() && date.valueOf()<=this.max.valueOf()) ? "CALENDAR-DAY " : "CALENDAR-DAY-LIMIT ") + // active sélection date entre min max
    (((date.getDate()==this.state.selectedDate.getDate()) &&
      (date.getMonth()==this.state.selectedDate.getMonth()) &&
      (date.getFullYear()==this.state.selectedDate.getFullYear())) ? "CALENDAR-DAY-SELECTED " : "") + // selected
     ((date.getDay() == 6 || date.getDay() == 0) ? "CALENDAR-DAY-OFF" : "") // samedi dimanche
    }
    onClick={((date.valueOf()>=this.today.valueOf()) && (date.valueOf()<=this.max.valueOf())) ? ((e)=>this.selectDate(e.target.attributes.date.value)) : ""}
    date={getDate(date)}  
   >{date.getDate()}</div>);
   date.setDate(date.getDate()+1);
  }
  return (<div>{days}</div>)
 };
 render() {
  return (
   <div>
   <div className="CALENDAR">
    <div className="CALENDAR-HEADER">
     <button className="CALENDAR-HEADER-BTN" onClick={this.subMonth}><i className="fa fa-angle-left"></i></button>
     <div className="CALENDAR-HEADER-ITEM">{this.state.months[this.state.date.getMonth()] + " " + this.state.date.getFullYear()}</div>
     <button className="CALENDAR-HEADER-BTN" onClick={this.addMonth}><i className="fa fa-angle-right"></i></button>
    </div>
    <div>
     {this.state.days.map( x => <div className="CALENDAR-WEEK CALENDAR-WEEK-ITEM">{x}</div>)}
     {this.renderDays()}
    </div>
   </div>
   <Booking date={this.state.selectedDate}/>
   </div>
  )
 };
}

ReactDOM.render(<Calendar/>, document.getElementById("calendar"));

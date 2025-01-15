export default function ViewLabel(props) {
    return(
        <p><span className="bold">{props.label}</span> : {props.var}</p>
    );
}
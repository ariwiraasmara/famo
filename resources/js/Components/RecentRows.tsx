import { For } from 'million/react';
export default function RecentRows(props) {
    return(
        <div className="m-t-30">
            <span className="bold underline">{props.recentlabel}</span>

            {props.model == 0 ? (
                <div className="column is-12">
                    Not In Membership
                </div>
            ) : (
                <div className="m-t-10 columns is-mobile ">
                    <For each={props.model} memo>{(body, index) => 
                        <div className="column is-3" key={index}>
                            <div className="box word-wrap text-is-black">
                                <span className="bold">{ body.props.recentrows1 }</span>
                                ({ body.props.recentrows1 })
                            </div>
                        </div>
                    }</For>
                </div>
             )}
        </div>
        
    );
}
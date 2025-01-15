import './style.css';
import { block, For } from 'million/react';
import { deleteMembership } from './external_function.ts';

export default function TableData({groupedData}) {
    return(
        <For each={groupedData} memo>{(group:any, index1:number) => 
            <div className="m-t-0 is-desktop is-mobile columns" id="body-membership">
                {group.map((item:any, index2:number) => (
                    <div className="column is-one-four" key={index1}>
                        <div className="box is-mobile">
                            <div className="is-mobile word-wrap text-is-black">
                                <span className="bold">{ item.membership }</span><br/>
                                ({item.email_membership})
                            </div>

                            <div className="m-t-10">
                                <button className="button is-danger is-fullwidth" id="btn-remove-membership" onClick={(event) => deleteMembership(event, item.membership, item.mid)}>
                                    <ion-icon name="remove-outline" size="large"></ion-icon>
                                </button>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        }</For>
    )
}

import './treeview.css';
import { treeview, deleteMember } from './external_function.ts';
import Child from './TableChildData';
import { Fragment } from 'react';
import { block, For } from 'million/react';
export default function TableData({ data }) {

    treeview();
    console.log('data table', data);
    return(
        /*<For each={data} memo>{(bodyparent:any, index:number) => 
            <li key={index}>
                {bodyparent.child_member.length > 0 ? (
                    <span className="caret bold">{bodyparent.member_name} ({bodyparent.email_member})</span>
                ) : (
                    <span className="">{bodyparent.member_name} ({bodyparent.email_member})</span>
                )}

                    <button className="buttontree" id="button-modal-member" onClick={(event) => openModal(event, bodyparent.id_member, bodyparent.member_name)}>
                        <ion-icon name="eye-outline"></ion-icon>
                    </button>
                    <button className="buttontree" id="button-remove-member" onClick={(event) => deleteMember(event, bodyparent.member_name, bodyparent.mid)}>
                        <ion-icon name="trash-outline"></ion-icon>
                    </button>

                {/* {bodyparent.child_member.length > 0 ? (
                    <ul className="nested">
                        {bodyparent.child_member.map((bodychild: object, index2: number) => (
                            <li key={index2}>
                                {bodychild.child_member_name} ({bodychild.child_email_member})
                            </li>
                        ))}
                    </ul>
                ) : (<span></span>)} /}
            </li>
        }</For>
        */
        /*data.map((body: any, index: number) => (
            <li key={index}>
            {body.child_member.length > 0 ? (
                <Fragment>
                    <span className="caret bold">{body.member_name} ({body.email_member})</span>
                    <button className="buttontree" id="button-remove-member" onClick={(event) => deleteMember(event, body.member_name, body.mid)}>
                        <ion-icon name="remove-outline"></ion-icon>
                    </button>
                </Fragment>
                
            ) : (
                <Fragment>
                    <span className="">{body.member_name} ({body.email_member})</span>
                    <button className="buttontree" id="button-remove-member" onClick={(event) => deleteMember(event, body.member_name, body.mid)}>
                        <ion-icon name="remove-outline"></ion-icon>
                    </button>
                </Fragment>
            )}
            </li>
            
            <li key={index}>{body.member_name} ({body.email_member})
                <button className="buttontree" id="button-remove-member" onClick={(event) => deleteMember(event, body.member_name, body.mid)}>
                    <ion-icon name="remove-outline"></ion-icon>
                </button>
            </li>
            
        ))*/
    )
}

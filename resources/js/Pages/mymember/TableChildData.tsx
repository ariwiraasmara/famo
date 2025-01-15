import './treeview.css';
import axios from 'axios';
import { treeview, getChildMember, deleteMember } from './external_function.ts';
import React, { useState, useEffect, Fragment } from "react";
import { block, For } from 'million/react';
export default function TableChildData({parent_index, parent_mid, parent_member_name, parent_member_email, child_data}) {

    treeview();
    /*
    const [childData, setChildData] = useState(null);

    useEffect(() => {
        async function fetchData() {
            try {
                // const response = await getChildMember(id_member_parent, 'mid', 'asc');
                const response = await axios.get(`api/member/all/${id_member_parent}`);
                // if(response.data[0] === null) setData(null);
                setChildData(response.data.data);
                console.log(`childData ${member_name_parent}`, childData);
                console.log(`childData ${member_name_parent} is null?`, childData == null);
            } catch (error) {
                console.error(error);
            }
        }
        fetchData();
    }, [id_member_parent]);
    */

    return(
        /*
        data === 0 ? (
            <li key={index_parent}>{member_name_parent} ({member_email_parent})
                <button className="buttontree" id="button-remove-member" onClick={(event) => deleteMember(event, member_name_parent, mid)}>
                    <ion-icon name="remove-outline"></ion-icon>
                </button>
            </li>
        ) : (
            <li key={index_parent}><span className="caret">{member_name_parent} ({member_email_parent})</span>
                <button className="buttontree" id="button-remove-member" onClick={(event) => deleteMember(event, member_name_parent, mid)}>
                    <ion-icon name="remove-outline"></ion-icon>
                </button>
                <ul className="nested">
                    {childData.map((body, index) => (
                        <li key={index}>
                            {body.member_name} ({body.email_member})
                        </li>
                    ))}
                </ul>
            </li>
        )

        
        <li key={index_parent}><span className="caret">{member_name_parent} ({member_email_parent})</span>
            <button className="buttontree" id="button-remove-member" onClick={(event) => deleteMember(event, member_name_parent, id_member_parent)}>
                <ion-icon name="remove-outline"></ion-icon>
            </button>
            <ul className="nested">
                {data.map((body, index) => (
                    <li key={index}>
                        {body.member_name} ({body.email_member})
                    </li>
                ))}
            </ul>
        </li>
        */
        bodyparent.child_member.length > 0 ? (
            <ul className="nested">
                {bodyparent.child_member.map((bodychild: object, index2: number) => (
                    <li key={index2}>
                        {bodychild.child_member_name} ({bodychild.child_email_member})
                    </li>
                ))}
            </ul>
        ) : (<span></span>)
    )
}

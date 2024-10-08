import React, { useState } from 'react';
import Modal from '@/Components/Modal';
import PrimaryButton from '@/Components/PrimaryButton';
import axios from 'axios';
import AuctionForm from '@/Components/AuctionForm';
import { FaEdit } from 'react-icons/fa';
import { FaDeleteLeft } from 'react-icons/fa6';

const SellerDashboard: React.FC = () => {
    const [auctions, setAuctions] = useState([]); // Fetch the list of auctions via API
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [currentAuction, setCurrentAuction] = useState(null); // For edit mode

    const handleDelete = async (auctionId) => {
        if (confirm("Are you sure you want to delete this auction?")) {
            try {
                await axios.delete(`/auctions/${auctionId}`);
                setAuctions(auctions.filter(auction => auction.id !== auctionId));
            } catch (error) {
                console.error('Error deleting auction', error);
            }
        }
    };

    const handleEdit = (auction) => {
        setCurrentAuction(auction);
        setIsModalOpen(true);
    };

    const handleCreate = () => {
        setCurrentAuction(null); // Reset for creating new
        setIsModalOpen(true);
    };

    return (
        <div className="p-6 bg-gray-50 rounded-md">
            <div className="flex justify-between items-center mb-6">
                <h1 className="text-2xl font-bold">My Listings</h1>
                <PrimaryButton onClick={handleCreate}>Create New Listing</PrimaryButton>
            </div>
            <table className="min-w-full bg-white shadow-md rounded mb-4">
                <thead>
                    <tr>
                        <th className="py-2">Title</th>
                        <th className="py-2">Current Price</th>
                        <th className="py-2">Status</th>
                        <th className="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {auctions.map((auction) => (
                        <tr key={auction.id} className="border-b">
                            <td className="py-2 px-4">{auction.title}</td>
                            <td className="py-2 px-4">${auction.current_price}</td>
                            <td className="py-2 px-4">{auction.status}</td>
                            <td className="py-2 px-4">
                                <PrimaryButton onClick={() => handleEdit(auction)}><FaEdit /></PrimaryButton>
                                <PrimaryButton className="ml-2" onClick={() => handleDelete(auction.id)} color="red"><FaDeleteLeft /></PrimaryButton>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>

            <Modal show={isModalOpen} onClose={() => setIsModalOpen(false)}>
                <AuctionForm auction={currentAuction} />
            </Modal>
        </div>
    );
};

export default SellerDashboard;
